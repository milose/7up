<?php

namespace Tests\Feature;

use App\File;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileDownloadTest extends TestCase
{
    use RefreshDatabase;

    private $file;

    protected function setUp() : void
    {
        parent::setUp();

        Storage::fake();

        $this->file = factory(File::class)->create();
    }

    /** @test */
    public function handles_not_found()
    {
        $response = $this->get('/unknown');

        $response->assertStatus(404);
    }

    /** @test */
    public function handles_file_download()
    {
        $response = $this->get('/'.$this->file->slug);

        $response->assertHeader('Content-Disposition', "attachment; filename={$this->file->name}");
    }

    /** @test */
    public function handles_file_download_with_new_name_parameter()
    {
        $response = $this->get('/'.$this->file->slug.'/newName.ext');

        $response->assertHeader('Content-Disposition', "attachment; filename=newName.ext");
    }
}
