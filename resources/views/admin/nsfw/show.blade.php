@extends('layouts.app')

@section('content')

<div class="max-w-sm rounded overflow-hidden shadow-lg">
    <img class="w-full" src="{{ route('admin.nsfw.load', $file) }}" alt="{{ $file->name }}">
    <div class="px-6 py-4">
        <div class="font-bold text-xl mb-2">{{ $file->name }}</div>
        <p class="text-gray-700 text-base">
            {{ $file->slug }}
        </p>
    </div>
    <div class="px-6 py-4">
        <span
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $file->nsfw_score }}</span>
        <span
            class="inline-block float-right bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ human_filesize($file->size) }}</span>
    </div>
    <div class="px-6 py-4">
        <button
            class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded">
            Remove
        </button>
        <button
            class="bg-green-500 hover:bg-green-400 text-white font-bold py-2 px-4 border-b-4 border-green-700 hover:border-green-500 rounded">
            OK
        </button>
    </div>
</div>

@endsection
