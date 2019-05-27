<?php

namespace App\Http\Controllers;

use App\File;
use App\Jobs\ClassifyImage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('json');
    }

    public function store()
    {
        request()->validate([
            'file' => 'required|file',
            'name' => 'nullable',
        ]);

        $file = File::createWithSlug([
                'name' => request('name') ?? request('file')->getClientOriginalName(),
                'size' => request('file')->getClientSize(),
                'is_image' => explode('/', request('file')->getClientMimeType())[0] === 'image',
            ]);

        request('file')->storeAs(config('7up.path'), $file->id, 'storage');

        $url = config('app.url').'/'.$file->slug;

        if ($file->is_image) {
            ClassifyImage::dispatch($file);
        }

        return
            "File {$file->name} uploaded.\n".
            "  {$url}\n".
            "To download use:\n".
            "  wget --content-disposition {$url}\n".
            "  curl -JLO {$url}\n";
    }

    public function show(File $file)
    {
        return response()->download(
            storage_path(config('7up.path') . $file->id),
            $file->name
        );
    }
}
