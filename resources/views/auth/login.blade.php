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
            --ss-ink: #17233f;
            --ss-muted: #68758d;
            --ss-navy: #1b2f63;
            --ss-navy-deep: #14254f;
            --ss-blue: #536ed0;
            --ss-gold: #ffd45a;
            --ss-line: #e3e8f2;
        }
        * { box-sizing: border-box; }
        html { min-height: 100%; }
        body {
            margin: 0; min-height: 100vh; background: #fff; color: var(--ss-ink);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a, button { -webkit-tap-highlight-color: transparent; }
        a:focus-visible { outline: 3px solid #8ca5ff; outline-offset: 3px; }
        .ss-page {
            min-height: 100vh; display: grid;
            grid-template-columns: minmax(340px, .84fr) minmax(0, 1.16fr);
        }
        .ss-welcome {
            position: relative; isolation: isolate; overflow: hidden; display: flex; flex-direction: column;
            justify-content: space-between; min-width: 0; padding: clamp(30px, 5vw, 66px);
            color: #fff; background: linear-gradient(150deg, var(--ss-navy) 0%, #1d3268 52%, #243c79 100%);
        }
        .ss-welcome::before, .ss-welcome::after {
            content: ""; position: absolute; z-index: -1; border: 1px solid rgba(255,255,255,.085);
            border-radius: 50%; pointer-events: none;
        }
        .ss-welcome::before { width: 520px; height: 520px; left: -300px; top: 8%; box-shadow: 0 0 0 42px rgba(255,255,255,.018), 0 0 0 92px rgba(255,255,255,.014); }
        .ss-welcome::after { width: 410px; height: 410px; right: -260px; bottom: -160px; box-shadow: 0 0 0 35px rgba(255,255,255,.02), 0 0 0 75px rgba(255,255,255,.015); }
        .ss-brand { display: inline-flex; align-items: center; gap: 12px; width: fit-content; position: relative; z-index: 1; }
        .ss-brand-mark {
            display: grid; place-items: center; width: 48px; height: 48px; flex: 0 0 48px; border-radius: 14px;
            color: #fff; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.13);
            box-shadow: 0 8px 24px rgba(5,13,38,.14);
        }
        .ss-brand-name { color: #fff; font-size: 1.28rem; font-weight: 850; letter-spacing: -.045em; }
        .ss-brand-caption { margin-top: 3px; color: #c7d2ee; font-size: .76rem; }
        .ss-hero { max-width: 570px; margin: 56px 0 54px; position: relative; z-index: 1; }
        .ss-eyebrow {
            display: inline-flex; align-items: center; gap: 9px; padding: 8px 12px; border-radius: 999px;
            border: 1px solid rgba(255,255,255,.13); background: rgba(255,255,255,.075); color: #e3eaff;
            font-size: .76rem; font-weight: 750; letter-spacing: .02em;
        }
        .ss-eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: #a2ecd0; box-shadow: 0 0 0 4px rgba(162,236,208,.1); }
        .ss-hero h1 {
            margin: 25px 0 18px; max-width: 550px; color: #fff; font-size: clamp(2.55rem, 4.5vw, 4.25rem);
            font-weight: 850; line-height: 1.04; letter-spacing: -.06em;
        }
        .ss-hero h1 span { color: var(--ss-gold); }
        .ss-hero p { max-width: 455px; margin: 0; color: #d8e1f7; font-size: .98rem; line-height: 1.85; }
        .ss-promise {
            display: flex; align-items: flex-start; gap: 13px; max-width: 470px; padding: 17px 18px;
            border: 1px solid rgba(255,255,255,.13); border-radius: 16px; background: rgba(255,255,255,.075);
            box-shadow: 0 12px 35px rgba(4,12,35,.08); backdrop-filter: blur(10px); position: relative; z-index: 1;
        }
        .ss-promise-icon { flex: 0 0 38px; display: grid; place-items: center; width: 38px; height: 38px; border-radius: 12px; background: rgba(162,236,208,.13); color: #a2ecd0; }
        .ss-promise strong { display: block; margin: 1px 0 5px; color: #fff; font-size: .88rem; }
        .ss-promise p { margin: 0; color: #c7d2ec; font-size: .78rem; line-height: 1.65; }
        .ss-footer { color: #b9c7e7; font-size: .76rem; position: relative; z-index: 1; }
        .ss-form-side {
            display: flex; align-items: center; justify-content: center; min-width: 0; padding: clamp(28px, 5vw, 76px);
            background: #fff;
        }
        .ss-form-wrap { width: 100%; max-width: 405px; }
        .ss-mobile-brand { display: none; }
        .ss-form-heading { margin-bottom: 28px; }
        .ss-form-heading .ss-small-label {
            margin: 0 0 10px; color: var(--ss-navy); font-size: .75rem; font-weight: 800;
            letter-spacing: .1em; text-transform: uppercase;
        }
        .ss-form-heading h2 { margin: 0; color: #101a30; font-size: clamp(2rem, 3vw, 2.45rem); font-weight: 800; letter-spacing: -.055em; line-height: 1.16; }
        .ss-form-heading p { margin: 11px 0 0; color: var(--ss-muted); font-size: .9rem; line-height: 1.7; }
        .ss-session-status { margin-bottom: 18px; }
        .ss-field { margin-top: 20px; }
        .ss-label { display: block; margin-bottom: 8px; color: #253453; font-size: .83rem; font-weight: 700; }
        input.ss-input {
            display: block; width: 100%; min-height: 49px; margin: 0; padding: 12px 14px;
            border: 1px solid #cfd8ed !important; border-radius: 11px !important; background: #fff !important;
            color: var(--ss-ink) !important; box-shadow: none !important; font-size: .89rem;
            transition: border-color .18s ease, box-shadow .18s ease;
        }
        input.ss-input::placeholder { color: #97a3b8; }
        input.ss-input:focus { border-color: #8297d9 !important; outline: none; box-shadow: 0 0 0 3px rgba(83,110,208,.12) !important; }
        .ss-error { margin-top: 7px; font-size: .8rem; color: #bd354a; }
        .ss-options { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 18px; }
        .ss-remember { display: inline-flex; align-items: center; gap: 9px; color: #62708a; font-size: .81rem; cursor: pointer; }
        .ss-remember input { width: 15px; height: 15px; accent-color: var(--ss-navy); }
        .ss-forgot { color: var(--ss-navy); font-size: .8rem; font-weight: 750; text-decoration: none; }
        .ss-forgot:hover { color: #3e5798; text-decoration: underline; }
        .ss-submit-row { margin-top: 25px; }
        button.ss-submit {
            display: inline-flex; align-items: center; justify-content: center; gap: 9px; width: 100%; min-height: 49px;
            padding: 12px 20px; border: 0 !important; border-radius: 11px !important; background: var(--ss-navy) !important;
            color: #fff !important; box-shadow: 0 8px 17px rgba(27,47,99,.15) !important; font-size: .88rem; font-weight: 800;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        }
        button.ss-submit:hover { transform: translateY(-1px); background: #263f7d !important; box-shadow: 0 11px 20px rgba(27,47,99,.2) !important; }
        button.ss-submit:focus-visible { outline: 3px solid rgba(83,110,208,.35); outline-offset: 3px; }
        .ss-security-note { display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 25px; color: #8994a8; font-size: .75rem; line-height: 1.55; text-align: center; }
        .ss-security-note svg { flex: 0 0 auto; }
        @media (max-width: 920px) {
            .ss-page { grid-template-columns: minmax(290px, .83fr) minmax(0, 1.17fr); }
            .ss-welcome { padding: 32px; }
            .ss-form-side { padding: 32px; }
            .ss-hero h1 { font-size: clamp(2.45rem, 4.8vw, 3.3rem); }
        }
        @media (max-width: 720px) {
            .ss-page { display: block; }
            .ss-welcome { display: none; }
            .ss-form-side { min-height: 100vh; padding: 28px 22px 35px; }
            .ss-form-wrap { max-width: 430px; }
            .ss-mobile-brand { display: inline-flex; margin-bottom: 38px; }
            .ss-mobile-brand .ss-brand-mark { background: var(--ss-navy); }
            .ss-mobile-brand .ss-brand-name { color: var(--ss-navy); }
            .ss-mobile-brand .ss-brand-caption { color: #7d899f; }
            .ss-form-heading { margin-bottom: 26px; }
            .ss-form-heading h2 { font-size: 2.1rem; }
        }
        @media (max-width: 380px) {
            .ss-options { align-items: flex-start; flex-direction: column; }
            .ss-mobile-brand { margin-bottom: 30px; }
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
