<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eugene</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <header class="bg-blue-500 py-4">
        <div class="container mx-auto px-4">
            <a href="/" class="text-white text-2xl px-2 font-semibold">{{ config('app.name', 'Eugene') }}</a>
            <a href="{{ route('doctors.index') }}" class="text-blue-400 text-2m px-3 py-1 bg-gray-100 rounded">Doctors</a>
            <a href="{{ route('tests.index') }}" class="text-blue-400 text-2m px-3 py-1 bg-gray-100 rounded">Tests</a>
            <a href="{{ route('clinics.index') }}" class="text-blue-400 text-2m px-3 py-1 bg-gray-100 rounded">Clinics</a>
        </div>
    </header>

    @if (session('success'))
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold">Success!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <main class="mt-8 mb-8">
        @yield('content')
    </main>

    <!-- Scripts -->
    @vite('resources/js/app.js')
</body>
</html>
