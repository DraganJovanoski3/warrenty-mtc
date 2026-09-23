<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MTC Warranty') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|ibm-plex-mono:500&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-100">
        <div class="min-h-screen flex flex-col">
            <header class="bg-slate-900 border-b border-slate-800">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between gap-4">
                    <a href="{{ route('public.form') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="MTC" class="h-10 w-auto">
                        <div>
                            <div class="text-white font-semibold tracking-wide">Warranty Tracker</div>
                            <div class="text-slate-400 text-xs">Installation information &amp; proof of application</div>
                        </div>
                    </a>
                    <div class="flex items-center gap-4 text-sm">
                        <a href="https://mtctruckparts.com/" class="text-slate-300 hover:text-white font-medium whitespace-nowrap" target="_blank" rel="noopener">Back to shop</a>
                        <a href="{{ route('public.form') }}" class="text-slate-300 hover:text-white font-medium whitespace-nowrap">Home</a>
                        <a href="{{ route('login') }}" class="text-amber-400 hover:text-amber-300 font-medium whitespace-nowrap">Staff login</a>
                    </div>
                </div>
            </header>

            <main class="flex-1 py-8">
                @if (session('success'))
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                        <div class="rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">{{ session('success') }}</div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="border-t border-slate-200 bg-white mt-auto">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row gap-2 sm:items-center sm:justify-between text-sm text-slate-500">
                    <span>MTC Installation &amp; Warranty Tracker</span>
                    <span class="flex flex-wrap gap-x-4 gap-y-1">
                        <a href="https://mtctruckparts.com/" class="hover:text-slate-800 hover:underline" target="_blank" rel="noopener">Back to shop</a>
                        <a href="{{ route('pages.privacy') }}" class="hover:text-slate-800 hover:underline">Privacy Policy</a>
                        <a href="{{ route('pages.warranty-policy') }}" class="hover:text-slate-800 hover:underline">Warranty Policy</a>
                    </span>
                </div>
            </footer>
        </div>
    </body>
</html>
