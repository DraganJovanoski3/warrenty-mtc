<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MTC Warranty') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|ibm-plex-mono:500&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased bg-slate-100 overflow-x-hidden">
        <div class="min-h-screen flex flex-col" x-data="{ open: false }">
            <header class="bg-slate-900 border-b border-slate-800">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
                    <div class="flex items-center justify-between gap-3">
                        <a href="{{ route('public.form') }}" class="flex items-center gap-2 sm:gap-3 min-w-0">
                            <img src="{{ asset('images/logo.png') }}" alt="MTC" class="h-8 sm:h-10 w-auto shrink-0">
                            <div class="min-w-0">
                                <div class="text-white font-semibold tracking-wide text-sm sm:text-base truncate">Warranty Tracker</div>
                                <div class="text-slate-400 text-xs hidden sm:block">Installation information &amp; proof of application</div>
                            </div>
                        </a>

                        <div class="hidden sm:flex items-center gap-4 text-sm shrink-0">
                            <a href="https://mtctruckparts.com/" class="text-slate-300 hover:text-white font-medium whitespace-nowrap" target="_blank" rel="noopener">Back to shop</a>
                            <a href="{{ route('public.form') }}" class="text-slate-300 hover:text-white font-medium whitespace-nowrap">Home</a>
                            <a href="{{ route('login') }}" class="text-amber-400 hover:text-amber-300 font-medium whitespace-nowrap">Staff login</a>
                        </div>

                        <button type="button"
                            class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-slate-300 hover:text-white hover:bg-slate-800"
                            @click="open = ! open"
                            :aria-expanded="open"
                            aria-label="Toggle menu">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open }" class="inline" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': ! open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div x-show="open" x-cloak class="sm:hidden mt-3 pt-3 border-t border-slate-800 space-y-1 pb-1">
                        <a href="https://mtctruckparts.com/" class="block px-3 py-2.5 rounded-md text-sm text-slate-200 hover:bg-slate-800" target="_blank" rel="noopener">Back to shop</a>
                        <a href="{{ route('public.form') }}" class="block px-3 py-2.5 rounded-md text-sm text-slate-200 hover:bg-slate-800">Home</a>
                        <a href="{{ route('pages.warranty-policy') }}" class="block px-3 py-2.5 rounded-md text-sm text-slate-200 hover:bg-slate-800">Warranty Policy</a>
                        <a href="{{ route('login') }}" class="block px-3 py-2.5 rounded-md text-sm text-amber-400 hover:bg-slate-800">Staff login</a>
                    </div>
                </div>
            </header>

            <main class="flex-1 py-5 sm:py-8">
                @if (session('success'))
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                        <div class="rounded-md bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">{{ session('success') }}</div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="border-t border-slate-200 bg-white mt-auto">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between text-sm text-slate-500">
                    <span>MTC Installation &amp; Warranty Tracker</span>
                    <span class="flex flex-wrap gap-x-4 gap-y-2">
                        <a href="https://mtctruckparts.com/" class="hover:text-slate-800 hover:underline" target="_blank" rel="noopener">Back to shop</a>
                        <a href="{{ route('pages.privacy') }}" class="hover:text-slate-800 hover:underline">Privacy Policy</a>
                        <a href="{{ route('pages.warranty-policy') }}" class="hover:text-slate-800 hover:underline">Warranty Policy</a>
                    </span>
                </div>
            </footer>
        </div>
    </body>
</html>
