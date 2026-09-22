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
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
            <div class="text-center mb-2">
                <img src="{{ asset('logo.png') }}" alt="MTC" class="h-14 w-auto mx-auto mb-3">
                <h1 class="text-white text-2xl font-semibold tracking-wide">Warranty Tracker</h1>
                <p class="text-slate-400 text-sm mt-1">Installation information &amp; proof of application</p>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white shadow-xl overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            <p class="mt-8 mb-6 text-center text-xs text-slate-400 px-4">
                Made by Dragan Jovanoski — DD Solutions<br>
                <a href="https://ddsolutions.com.mk/" class="text-amber-400 hover:underline" target="_blank" rel="noopener">https://ddsolutions.com.mk/</a>
            </p>
        </div>
    </body>
</html>
