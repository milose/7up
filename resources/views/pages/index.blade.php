@extends('layouts.app')

@section('content')

<section class="mb-6">
    <h2 class="text-2xl leading-loose">Usage</h2>
    <p><span class="font-mono font-semibold text-blue-800">7up</span> is a free file upload service. Small files are
        kept for 7 days, and larger files for 7 hours.</p>
</section>

<ul class="flex">
    <li class="flex-1 mr-2 cursor-pointer" @click="selectTab(0)">
        <a :class="getTabClass(0)">7up</a>
    </li>
    <li class="flex-1 mr-2 cursor-pointer" @click="selectTab(1)">
        <a :class="getTabClass(1)">Installation</a>
    </li>
    <li class="flex-1 mr-2 cursor-pointer" @click="selectTab(2)">
        <a :class="getTabClass(2)">Using curl</a>
    </li>
</ul>

<hr class="border">

<section :class="getContainerClass(0)">
    <p class="py-2">Examples:</p>
    <pre><code class="language-bash shadow-md m-2 md:m-3"><strong>7up</strong> /tmp/readme.md
<strong>7up</strong> /tmp/readme.md name.md        # with a new name
cat /tmp/readme.md | <strong>7up</strong> name.md  # using a pipe operator
</code></pre>
    <div class="m-2 md:m-3">
        <div class="py-2">To use <span class="font-mono font-semibold text-blue-800">7up</span> command in the
            terminal you need to install it.</div>
        <button class="p-2 bg-blue-800 items-center text-blue-100 leading-none rounded flex inline-flex"
            @click="selectTab(1)">
            <span class="flex rounded-full bg-gray-600 px-2 py-1 text-xs font-bold mr-3">
                <pre>.sh</pre></span>
            <span class="font-semibold mr-2 text-left flex-auto">Install</span>
            <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z" />
            </svg>
        </button>
    </div>
</section>

<section :class="getContainerClass(1)">
    <p class="py-2">To install <span class="font-mono font-semibold text-blue-800">7up</span>, simply add this
        function to your <span class="font-mono text-blue-500">~/.bash_profile</span> (MacOS) or <span
            class="font-mono text-blue-500">~/.bashrc</span> (Ubuntu).</p>
    <pre><code class="language-bash m-2 md:m-3 shadow-md">7up ()
{
    if [ $# -eq 0 ]; then
        echo -e "No arguments specified. Usage:\n  7up /tmp/readme.md\n  7up /tmp/readme.md name.md\n  cat /tmp/readme.md | 7up name.md"
        return 1
    fi

    URL='{{ config('app.url') }}'
    FILENAME=''
    RESPONSE=''

    if tty -s; then
        if [ ! -f "$1" ]; then
            echo "File $1 not found"
            return 1
        fi
        if [ $# -eq 2 ]; then
            FILENAME="-F name=$2"
        fi
        RESPONSE=$(curl --progress-bar -F "file=@$1" ${FILENAME} ${URL})
    else
        RESPONSE=$(curl --progress-bar -F file=@- -F "name=$1" ${URL})
    fi

    echo "${RESPONSE}"
}</code></pre>
</section>

<section :class="getContainerClass(2)">
    <p class="py-2">Alternatively, you can use curl to upload files:</p>
    <pre><code class="language-bash m-2 md:m-3 shadow-md">curl -F "file=@log_file.tar.gz" {{ config('app.url') }}
curl -F "file=@log_file.tar.gz" -F "name=log.gz" {{ config('app.url') }} # with a new name</code></pre>
</section>

@endsection
