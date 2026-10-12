<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#6b1a28">

        <title>{{ config('app.name', 'SafeSpace') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-paper text-ink">
        <div class="min-h-screen flex flex-col bg-paper">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white border-b border-brand-100">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="text-center text-xs text-gray-500 py-5 border-t border-brand-100 bg-white">
                <a href="{{ route('privacy') }}" class="underline hover:text-brand-700">Privacy Notice</a> · SafeSpace · East Central Integrated School
            </footer>
        </div>

        @auth
            @if (auth()->user()->isStudent())
                <x-chatbot-widget />
            @endif
        @endauth
    </body>
</html>