<?php

namespace App\Http\Controllers\Admin;

use App\File;
use App\Http\Controllers\Controller;

class NsfwImageLoadController extends Controller
{
    public function show(File $file)
    {
        $fileName = config('7up.storage').'/'.config('7up.path').'/'.$file->id;

        return response()->file($fileName);
    }
}
