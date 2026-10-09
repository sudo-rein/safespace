<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in | SafeSpace</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            color-scheme: light;
            --ss-ink: #1d2b4f;
            --ss-muted: #687793;
            --ss-blue: #5276e8;
            --ss-blue-dark: #3f5fc9;
            --ss-lavender: #eeeaff;
            --ss-line: #e5eaf5;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f7f9ff;
            color: var(--ss-ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .ss-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1.02fr) minmax(420px, .98fr);
        }

        .ss-welcome {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(30px, 5vw, 68px);
            background:
                radial-gradient(circle at 8% 90%, rgba(168, 180, 255, .35), transparent 28%),
                radial-gradient(circle at 87% 18%, rgba(163, 221, 255, .42), transparent 27%),
                linear-gradient(145deg, #edf4ff 0%, #f4f0ff 55%, #f7f9ff 100%);
        }

        .ss-welcome::before,
        .ss-welcome::after {
            content: "";
            position: absolute;
            z-index: -1;
            border: 1px solid rgba(103, 126, 220, .12);
            border-radius: 50%;
            pointer-events: none;
        }

        .ss-welcome::before { width: 440px; height: 440px; right: -220px; bottom: -145px; }
        .ss-welcome::after { width: 310px; height: 310px; right: -155px; bottom: -80px; }

        .ss-brand { display: inline-flex; align-items: center; gap: 12px; width: fit-content; }
        .ss-brand-mark {
            display: grid;
            place-items: center;
            width: 46px;
            height: 46px;
            border-radius: 16px;
            color: #fff;
            background: linear-gradient(145deg, #6888f4, #8c82ec);
            box-shadow: 0 10px 24px rgba(82, 118, 232, .25);
        }
        .ss-brand-name { font-size: 1.24rem; font-weight: 800; letter-spacing: -.04em; }
        .ss-brand-caption { margin-top: 1px; color: var(--ss-muted); font-size: .76rem; }

        .ss-hero { max-width: 560px; margin: 68px 0 54px; }
        .ss-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid rgba(104, 136, 244, .18);
            border-radius: 999px;
            background: rgba(255, 255, 255, .62);
            color: #536dc5;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .02em;
        }
        .ss-eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: #73bca7; }
        .ss-hero h1 {
            margin: 24px 0 18px;
            max-width: 540px;
            font-size: clamp(2.6rem, 5vw, 4.35rem);
            font-weight: 800;
            line-height: 1.04;
            letter-spacing: -.065em;
            color: #202f57;
        }
        .ss-hero h1 span {
            background: linear-gradient(100deg, #5578e5, #8b78dc);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .ss-hero p { max-width: 455px; margin: 0; color: #64728e; font-size: 1.02rem; line-height: 1.8; }

        .ss-promise {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            max-width: 435px;
            padding: 18px 19px;
            border: 1px solid rgba(255,255,255,.85);
            border-radius: 20px;
            background: rgba(255,255,255,.62);
            box-shadow: 0 12px 35px rgba(60, 80, 140, .05);
            backdrop-filter: blur(10px);
        }
        .ss-promise-icon {
            flex: 0 0 38px;
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 13px;
            background: #e8f7f1;
            color: #2d9d7b;
        }
        .ss-promise strong { display: block; margin: 1px 0 4px; font-size: .88rem; }
        .ss-promise p { margin: 0; color: var(--ss-muted); font-size: .79rem; line-height: 1.6; }
        .ss-footer { color: #8390a9; font-size: .76rem; }

        .ss-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(28px, 5vw, 72px);
            background: rgba(255,255,255,.88);
        }
        .ss-form-wrap { width: 100%; max-width: 430px; }
        .ss-mobile-brand { display: none; }
        .ss-form-heading { margin-bottom: 30px; }
        .ss-form-heading .ss-small-label {
            margin: 0 0 12px;
            color: var(--ss-blue);
            font-size: .77rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .ss-form-heading h2 { margin: 0; color: var(--ss-ink); font-size: clamp(2rem, 3.4vw, 2.55rem); font-weight: 800; letter-spacing: -.055em; line-height: 1.15; }
        .ss-form-heading p { margin: 12px 0 0; color: var(--ss-muted); font-size: .94rem; line-height: 1.65; }

        .ss-session-status { margin-bottom: 18px; }
        .ss-field { margin-top: 21px; }
        .ss-label { display: block; margin-bottom: 9px; color: #354364; font-size: .86rem; font-weight: 700; }
        input.ss-input {
            display: block;
            width: 100%;
            min-height: 52px;
            margin-top: 0;
            padding: 13px 15px;
            border: 1px solid #dfe5f1 !important;
            border-radius: 13px !important;
            background: #fbfcff !important;
            color: var(--ss-ink) !important;
            box-shadow: none !important;
            font-size: .91rem;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }
        input.ss-input::placeholder { color: #9aa5bb; }
        input.ss-input:focus {
            border-color: #7891ed !important;
            background: #fff !important;
            outline: none;
            box-shadow: 0 0 0 4px rgba(104, 136, 244, .13) !important;
        }
        .ss-error { margin-top: 7px; font-size: .81rem; }

        .ss-options { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 19px; }
        .ss-remember { display: inline-flex; align-items: center; gap: 9px; color: #687793; font-size: .83rem; cursor: pointer; }
        .ss-remember input { width: 16px; height: 16px; accent-color: var(--ss-blue); border-radius: 5px; }
        .ss-forgot { color: #5874d8; font-size: .82rem; font-weight: 700; text-decoration: none; }
        .ss-forgot:hover { color: #344fb9; text-decoration: underline; }
        .ss-submit-row { margin-top: 27px; }
        button.ss-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 53px;
            padding: 13px 20px;
            border: 0 !important;
            border-radius: 14px !important;
            background: linear-gradient(110deg, #5f80ec, #7774e3) !important;
            color: #fff !important;
            box-shadow: 0 10px 20px rgba(82, 118, 232, .22) !important;
            font-size: .94rem;
            font-weight: 800;
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }
        button.ss-submit:hover { transform: translateY(-1px); filter: brightness(1.03); box-shadow: 0 13px 23px rgba(82,118,232,.27) !important; }
        button.ss-submit:focus-visible { outline: 3px solid rgba(82,118,232,.35); outline-offset: 3px; }
        .ss-security-note { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 25px; color: #8a96ad; font-size: .77rem; text-align: center; }
        .ss-security-note svg { flex: 0 0 auto; }

        @media (max-width: 900px) {
            .ss-page { grid-template-columns: minmax(0, 1fr) minmax(380px, .9fr); }
            .ss-welcome { padding: 34px; }
            .ss-form-side { padding: 34px; }
            .ss-hero h1 { font-size: clamp(2.45rem, 5vw, 3.5rem); }
        }
        @media (max-width: 720px) {
            .ss-page { display: block; }
            .ss-welcome { display: none; }
            .ss-form-side { min-height: 100vh; padding: 30px 22px; }
            .ss-form-wrap { max-width: 430px; }
            .ss-mobile-brand { display: inline-flex; margin-bottom: 42px; }
            .ss-form-heading { margin-bottom: 27px; }
            .ss-form-heading h2 { font-size: 2.15rem; }
        }
        @media (max-width: 380px) {
            .ss-options { align-items: flex-start; flex-direction: column; }
            .ss-mobile-brand { margin-bottom: 32px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
    <main class="ss-page">
        <section class="ss-welcome" aria-label="About SafeSpace">
            <div class="ss-brand">
                <div class="ss-brand-mark" aria-hidden="true">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2.8 20 6v5.4c0 5.1-3.3 8.5-8 10.1-4.7-1.6-8-5-8-10.1V6l8-3.2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        <path d="M8.2 12.1 10.7 14.5 15.9 9.4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div>
                    <div class="ss-brand-name">SafeSpace</div>
                    <div class="ss-brand-caption">A school community that listens</div>
                </div>
            </div>

            <div class="ss-hero">
                <div class="ss-eyebrow"><span class="ss-eyebrow-dot"></span> A little space to be heard</div>
                <h1>Your voice matters.<br><span>You matter, too.</span></h1>
                <p>Everyone deserves to feel safe, respected, and supported at school. SafeSpace gives you a way to speak up and ask for help when something isn't right.</p>
            </div>

            <div>
                <div class="ss-promise">
                    <div class="ss-promise-icon" aria-hidden="true">
                        <svg width="21" height="21" viewBox="0 0 24 24" fill="none">
                            <path d="M12 3 19 6v5c0 4.4-2.8 7.6-7 9.5C7.8 18.6 5 15.4 5 11V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            <path d="M9 12.1 11 14l4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <strong>A place to speak up</strong>
                        <p>Share a concern and let the appropriate school support personnel help guide the next steps.</p>
                    </div>
                </div>
                <div class="ss-footer" style="margin-top: 26px;">SafeSpace · East Central Integrated School</div>
            </div>
        </section>

        <section class="ss-form-side" aria-labelledby="signin-title">
            <div class="ss-form-wrap">
                <div class="ss-brand ss-mobile-brand">
                    <div class="ss-brand-mark" aria-hidden="true">
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2.8 20 6v5.4c0 5.1-3.3 8.5-8 10.1-4.7-1.6-8-5-8-10.1V6l8-3.2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            <path d="M8.2 12.1 10.7 14.5 15.9 9.4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="ss-brand-name">SafeSpace</div>
                        <div class="ss-brand-caption">A school community that listens</div>
                    </div>
                </div>

                <div class="ss-form-heading">
                    <p class="ss-small-label">Welcome back</p>
                    <h2 id="signin-title">Sign in to SafeSpace</h2>
                    <p>Use your student LRN or counselor email to continue.</p>
                </div>

                <!-- Session Status: kept for Laravel authentication feedback -->
                <div class="ss-session-status">
                    <x-auth-session-status :status="session('status')" />
                </div>

                <!-- Authentication form logic intentionally preserved -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="ss-field">
                        <x-input-label for="login" value="LRN or Email" class="ss-label" />
                        <x-text-input
                            id="login"
                            class="ss-input"
                            type="text"
                            name="login"
                            :value="old('login')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="12-digit LRN or counselor email"
                        />
                        <x-input-error :messages="$errors->get('login')" class="ss-error" />
                    </div>

                    <div class="ss-field">
                        <x-input-label for="password" :value="__('Password')" class="ss-label" />
                        <x-text-input
                            id="password"
                            class="ss-input"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                        />
                        <x-input-error :messages="$errors->get('password')" class="ss-error" />
                    </div>

                    <div class="ss-options">
                        <label for="remember_me" class="ss-remember">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="ss-forgot" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="ss-submit-row">
                        <x-primary-button class="ss-submit">
                            {{ __('Log in') }}
                            <svg style="margin-left: 9px;" width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </x-primary-button>
                    </div>
                </form>

                <div class="ss-security-note">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="5" y="10" width="14" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                    <span>Use your own account and keep your password private.</span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
