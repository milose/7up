@component('mail::message')
# Potential NSFW Content

Someone uploaded an image with NSFW score of: {{ $file->nsfw_score }}

@component('mail::button', ['url' => route('admin.nsfw.show', $file)])
Show Image
@endcomponent

@endcomponent
