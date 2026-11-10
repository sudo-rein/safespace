<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#6b1a28">
    <title>Privacy Notice | SafeSpace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-paper text-ink">
@php
    $dpoName = config('safespace.dpo_name');
    $dpoContact = config('safespace.dpo_contact');
    $isEmail = filter_var($dpoContact, FILTER_VALIDATE_EMAIL);
    $backUrl = auth()->check() ? route('dashboard') : url('/');

    $sections = [
        ['What we collect', 'Your LRN, name, grade level, and section when you register, and the details you enter in an incident report: date, time, place, people involved, description, and optional evidence files.'],
        ['Why we collect it', 'Only to receive, review, and manage bullying reports, as required of schools under the Anti-Bullying Act (RA 10627).'],
        ['Who can see it', 'Only authorized guidance personnel. If you report confidentially, your name is visible to guidance personnel only. Other students, including those named in a report, are never told who reported.'],
        ['How it is protected', 'Role-based access, private file storage, and an audit log that records who viewed a report. The keyword checker runs on the school\'s own server, and no report text is sent to outside services.'],
        ['How long we keep it', 'Closed cases are kept for ' . config('safespace.retention_years') . ' year(s), then reviewed for archiving or deletion.'],
        ['Your rights', 'Under the Data Privacy Act (RA 10173) you may ask to see, correct, or request deletion of your data, and you may raise a concern about how it is handled.'],
    ];
@endphp

<header class="bg-white border-b border-brand-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5" aria-label="SafeSpace home">
            <span class="grid place-items-center w-9 h-9 rounded-xl bg-brand-700 text-white shadow-sm">
                <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5" aria-hidden="true">
                    <path d="M12 21s-7.2-4.1-7.2-10V5.5L12 3l7.2 2.5V11c0 5.9-7.2 10-7.2 10Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                    <path d="M8.1 12.2h2l1.2-2.3 1.5 4 1.1-1.8h2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <span class="text-lg font-extrabold tracking-tight text-brand-700">Safe<span class="text-brand-400">Space</span></span>
        </a>
        <a href="{{ $backUrl }}" class="text-sm font-semibold text-brand-700 hover:underline">&larr; Back</a>
    </div>
</header>

<main class="max-w-4xl mx-auto px-4 sm:px-6 py-10 space-y-8">

    {{-- Hero --}}
    <div class="rounded-2xl bg-gradient-to-br from-brand-800 via-brand-700 to-brand-600 text-white p-8 shadow-sm">
        <p class="text-xs uppercase tracking-widest text-brand-200 font-semibold">Data Privacy Act (RA 10173)</p>
        <h1 class="mt-2 text-3xl font-extrabold tracking-tight">Privacy Notice</h1>
        <p class="mt-2 text-brand-100 max-w-2xl text-sm leading-relaxed">
            SafeSpace · East Central Integrated School. Your information deserves care. This page explains what we collect, who can see it, and how to reach our Data Protection Officer.
        </p>
    </div>

    {{-- DPO card --}}
    <section class="bg-white rounded-2xl border-2 border-brand-700 p-6 sm:p-8" aria-labelledby="dpo-title">
        <div class="flex items-start gap-4">
            <span class="grid place-items-center w-12 h-12 shrink-0 rounded-xl bg-brand-50 text-brand-700">
                <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6" aria-hidden="true">
                    <path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                    <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-xs uppercase tracking-widest text-brand-500 font-semibold">Contact</p>
                <h2 id="dpo-title" class="text-xl font-bold text-ink">Data Protection Officer</h2>
                <p class="mt-1 text-sm text-gray-600">Reach out to ask for your data, correct it, or raise a privacy concern.</p>
            </div>
        </div>

        <dl class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-xl bg-brand-50 p-4">
                <dt class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Name</dt>
                <dd class="mt-1 font-semibold text-ink break-words">{{ $dpoName }}</dd>
            </div>
            <div class="rounded-xl bg-brand-50 p-4">
                <dt class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Contact</dt>
                <dd class="mt-1 font-semibold text-ink break-words">
                    @if ($isEmail)
                        <a href="mailto:{{ $dpoContact }}" class="text-brand-700 underline">{{ $dpoContact }}</a>
                    @else
                        {{ $dpoContact }}
                    @endif
                </dd>
            </div>
        </dl>

        @if ($isEmail)
            <a href="mailto:{{ $dpoContact }}?subject=SafeSpace%20data%20request"
               class="mt-5 inline-flex items-center px-4 py-2.5 bg-brand-700 hover:bg-brand-600 text-white rounded-[11px] text-sm font-semibold shadow-sm transition">
                Email the DPO
            </a>
        @endif
    </section>

    {{-- Notice sections --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($sections as [$title, $text])
            <section class="bg-white rounded-2xl border border-brand-100 p-6">
                <h2 class="font-bold text-ink">{{ $title }}</h2>
                <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $text }}</p>
            </section>
        @endforeach
    </div>

    <p class="text-center text-xs text-gray-500">
        This notice is not legal advice. Questions about it can be sent to the Data Protection Officer above.
    </p>
</main>

<footer class="text-center text-xs text-gray-500 py-5 border-t border-brand-100 bg-white">
    SafeSpace · East Central Integrated School
</footer>
</body>
</html>