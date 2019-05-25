<?php

namespace App\Http\Controllers;

use App\File;

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

        $size = request('file')->getClientSize();

        $file = tap(File::createUnique())->update([
            'name' => request('name') ?? request('file')->getClientOriginalName(),
            'size' => $size,
            'expires_at' => ($size < 262144) ? now()->addhours(7) : now()->addDays(7),
        ]);

        request('file')->storeAs('files', $file->id, 'local');

        $url = config('app.url').'/'.$file->slug;

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
            storage_path('app/files/' . $file->id),
            $file->name
        );
    }
}
