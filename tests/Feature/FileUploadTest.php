<?php

namespace Tests\Feature;

use App\File;
use App\Admin;
use Tests\TestCase;
use App\Jobs\ClassifyImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageClassificationService;
use App\Notifications\NsfwThresholdExceeded;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    /** @test */
    public function upload_validation_rules()
    {
        Queue::fake();

        $response = $this->json('POST', '/', [
            'name' => UploadedFile::fake()->image('photo.jpg')
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function upload_with_original_name()
    {
        Queue::fake();

        $response = $this->json('POST', '/', [
            'file' => UploadedFile::fake()->create('document.pdf'),
        ]);

        $response->assertHeader('X-File-Url');
        $response->assertHeader('X-File-Name', 'document.pdf');
        $response->assertHeader('X-File-Handle');

        $response->assertStatus(201);
    }

    /** @test */
    public function upload_with_new_name()
    {
        Queue::fake();

        $response = $this->json('POST', '/', [
            'name' => 'newName.pdf',
            'file' => UploadedFile::fake()->create('document.pdf'),
        ]);

        $response->assertHeader('X-File-Url');
        $response->assertHeader('X-File-Name', 'newName.pdf');
        $response->assertHeader('X-File-Handle');

        $response->assertStatus(201);
    }

    /** @test */
    public function small_upload_size()
    {
        Queue::fake();

        $kbs = 8;
        $expectedSize = 8*1024;

        $response = $this->json('POST', '/', [
            'file' => UploadedFile::fake()->create('document.pdf', $kbs),
        ]);

        $file = File::where('slug', $response->headers->get('X-File-Handle'))->first();

        $this->assertEquals($expectedSize, $file->size);

        $this->assertEquals(now()->diffInDays($file->expires_at), 7);
    }

    /** @test */
    public function large_upload_size()
    {
        Queue::fake();

        $kbs = 264;
        $expectedSize = 264*1024;

        $response = $this->json('POST', '/', [
            'file' => UploadedFile::fake()->create('document.pdf', $kbs),
        ]);

        $file = File::where('slug', $response->headers->get('X-File-Handle'))->first();

        $this->assertEquals($expectedSize, $file->size);

        $this->assertEquals(now()->subMinute()->diffInHours($file->expires_at), 7);
    }

    /** @test */
    public function upload_detect_image()
    {
        Queue::fake();

        $response = $this->json('POST', '/', [
            'file' => UploadedFile::fake()->image('image'),
        ]);

        $file = File::where('slug', $response->headers->get('X-File-Handle'))->first();

        $this->assertTrue($file->is_image);
    }

    /** @test */
    public function image_classification_runs()
    {
        Queue::fake();

        $response = $this->json('POST', '/', [
            'file' => UploadedFile::fake()->image('image.jpg'),
            ]);

        $file = File::where('slug', $response->headers->get('X-File-Handle'))->first();

        Queue::assertPushed(ClassifyImage::class, function ($job) use ($file) {
            return $job->file->id === $file->id;
        });
    }

    /** @test */
    public function image_classification_does_not_run_on_documents()
    {
        Queue::fake();

        $response = $this->json('POST', '/', [
            'file' => UploadedFile::fake()->create('document.pdf'),
            ]);

        Queue::assertNotPushed(ClassifyImage::class);
    }

    /** @test */
    public function nsfw_threshold_notification()
    {
        Notification::fake();

        $admin = factory(Admin::class)->create();

        $this->mock(ImageClassificationService::class, function ($mock) {
            $mock->shouldReceive('classify')->andReturns(0.1, 0.9);
        });

        $this->json('POST', '/', [
            'file' => UploadedFile::fake()->image('image.jpg'),
            ]);

        Notification::assertNotSentTo(
            $admin,
            NsfwThresholdExceeded::class
        );

        $this->json('POST', '/', [
            'file' => UploadedFile::fake()->image('image.jpg'),
            ]);

        Notification::assertSentTo(
            $admin,
            NsfwThresholdExceeded::class
        );
    }
}
