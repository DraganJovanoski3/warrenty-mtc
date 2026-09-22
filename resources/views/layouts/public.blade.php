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
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-amber-500 text-slate-900 font-bold text-sm">MTC</span>
                        <div>
                            <div class="text-white font-semibold tracking-wide">Warranty Tracker</div>
                            <div class="text-slate-400 text-xs">Installation information &amp; proof of application</div>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" class="text-sm text-amber-400 hover:text-amber-300 font-medium whitespace-nowrap">Staff login</a>
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
                    <span>
                        Made by Dragan Jovanoski — DD Solutions
                        <a href="https://ddsolutions.com.mk/" class="text-amber-700 hover:underline font-medium" target="_blank" rel="noopener">https://ddsolutions.com.mk/</a>
                    </span>
                </div>
            </footer>
        </div>
    </body>
</html>
