<?php

namespace App\Jobs;

use App\File;
use App\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\ImageClassificationService;
use App\Notifications\NsfwThresholdExceeded;

class ClassifyImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function handle(ImageClassificationService $image)
    {
        $nsfw_score = $image->classify($this->file->id);

        $this->file->update(compact('nsfw_score'));

        if ($nsfw_score > config('7up.nsfw.threshold')) {
            Admin::all()->each->notify(new NsfwThresholdExceeded($this->file));
        }
    }
}
