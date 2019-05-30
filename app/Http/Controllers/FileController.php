<?php

namespace App\Http\Controllers;

use App\File;
use App\Jobs\ClassifyImage;
use Illuminate\Support\Facades\Storage;

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
                'name' => request('name') ?: request('file')->getClientOriginalName(),
                'size' => request('file')->getClientSize(),
                'is_image' => explode('/', \File::mimeType(request('file')->getPathName()))[0] === 'image',
            ]);

        request('file')->storeAs(null, $file->id, 'bucket');

        $url = config('app.url').'/'.$file->slug;

        if ($file->is_image) {
            ClassifyImage::dispatch($file);
        }

        return response("File {$file->name} uploaded.\n".
                "  {$url}\n".
                "To download use:\n".
                "  wget --content-disposition {$url}\n".
                "  curl -JLO {$url}\n", 201)
            ->header('X-File-Url', $url)
            ->header('X-File-Name', $file->name)
            ->header('X-File-Handle', $file->slug);
    }

    public function show(File $file)
    {
        return Storage::disk('bucket')->download($file->id, $file->name);
    }
}
