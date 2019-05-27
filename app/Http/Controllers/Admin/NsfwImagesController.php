<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Controllers\Controller;

class NsfwImagesController extends Controller
{
    public function index()
    {
        return view('admin.nsfw.show');
    }

    public function show(File $file)
    {
        abort_unless($file->is_image, 415, 'Unsupported Media Type');

        return view('admin.nsfw.show')
            ->withFile($file);
    }
}
