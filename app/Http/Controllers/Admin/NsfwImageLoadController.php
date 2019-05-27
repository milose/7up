<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class NsfwImageLoadController extends Controller
{
    public function show(File $file)
    {
        abort_unless($file->is_image, 415, 'Unsupported Media Type');

        return Storage::disk('bucket')->get($file->id);
    }
}
