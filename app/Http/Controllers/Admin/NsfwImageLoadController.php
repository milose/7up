<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Controllers\Controller;

class NsfwImageLoadController extends Controller
{
    public function show(File $file)
    {
        abort_unless($file->is_image, 415, 'Unsupported Media Type');

        return response()->file($fileName);
    }
}
