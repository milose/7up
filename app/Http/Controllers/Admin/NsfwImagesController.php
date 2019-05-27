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
        return view('admin.nsfw.show')
            ->withFile($file);
    }
}
