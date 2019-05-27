<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- @TODO: Open Graph -->

    @stack('top')
</head>

<body class="bg-gray-100 h-screen antialiased leading-none">
    <div id="app">
        <nav class="bg-blue-900 shadow mb-8 py-6">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-center">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                            {{ config('app.name', 'Laravel') }}
                            <!-- @TODO: Logo -->
                        </a>
                    </div>
                    <div class="flex-1 text-right">
                        @guest
                        <a class="no-underline hover:underline text-gray-300 text-sm p-3"
                            href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                        <a class="no-underline hover:underline text-gray-300 text-sm p-3"
                            href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                        @else
                        <span class="text-gray-300 text-sm pr-4">
                            <a
                                href="{{ me()->is_admin ? route('dashboard') : route('home')}}">{{ Auth::user()->name }}</a></span>

                        <a href="{{ route('logout') }}" class="no-underline hover:underline text-gray-300 text-sm p-3"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <div class="container mx-auto px-6 md:px-0">
                @yield('content')
        </div>

    </div>

    <footer class="bg-gray-200 text-gray-800 text-xs shadow mt-8 py-6">
        <div class="container mx-auto text-center px-6 md:px-0">made with
            <svg class="fill-current text-red-300 inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <path d="M10 3.22l-.61-.6a5.5 5.5 0 0 0-7.78 7.77L10 18.78l8.39-8.4a5.5 5.5 0 0 0-7.78-7.77l-.61.61z">
                </path>
            </svg>
            by <a target="_blank" href="https://milos.link">milos</a> &mdash;
            <!-- @TODO: Repository -->
            <a target="_blank" href="https://github.com/milose">github</a> |
            <a target="_blank" href="https://liberapay.com/milose/donate">donate</a>

            <p class="mt-3 text-gray-500"><a href="https://7up.com">7UP</a> is a trademark of Dr Pepper/Seven Up, Inc.
            </p>
        </div>
    </footer>

    @stack('bottom')
</body>

</html>
