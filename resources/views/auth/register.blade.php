<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account | SafeSpace</title>

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
        html { min-height: 100%; }
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
            grid-template-columns: minmax(290px, .78fr) minmax(0, 1.22fr);
        }

        .ss-welcome {
            position: sticky;
            top: 0;
            isolation: isolate;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-self: start;
            height: 100vh;
            min-height: 650px;
            padding: clamp(30px, 4.5vw, 62px);
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
            flex: 0 0 46px;
            border-radius: 16px;
            color: #fff;
            background: linear-gradient(145deg, #6888f4, #8c82ec);
            box-shadow: 0 10px 24px rgba(82, 118, 232, .25);
        }
        .ss-brand-name { font-size: 1.24rem; font-weight: 800; letter-spacing: -.04em; }
        .ss-brand-caption { margin-top: 1px; color: var(--ss-muted); font-size: .76rem; }

        .ss-hero { max-width: 480px; margin: 54px 0; }
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
            font-size: clamp(2.45rem, 4.2vw, 3.65rem);
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -.065em;
            color: #202f57;
        }
        .ss-hero h1 span {
            background: linear-gradient(100deg, #5578e5, #8b78dc);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .ss-hero > p { margin: 0; color: #64728e; font-size: .98rem; line-height: 1.8; }

        .ss-benefits { display: grid; gap: 12px; margin-top: 28px; }
        .ss-benefit {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border: 1px solid rgba(255,255,255,.86);
            border-radius: 16px;
            background: rgba(255,255,255,.57);
        }
        .ss-benefit-icon {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            border-radius: 11px;
            background: #e8f7f1;
            color: #2d9d7b;
        }
        .ss-benefit strong { display: block; margin: 1px 0 3px; font-size: .84rem; }
        .ss-benefit p { margin: 0; color: var(--ss-muted); font-size: .77rem; line-height: 1.55; }
        .ss-footer { color: #8390a9; font-size: .76rem; }

        .ss-form-side {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            min-width: 0;
            padding: clamp(28px, 4.5vw, 60px);
            background: rgba(255,255,255,.9);
        }
        .ss-form-wrap { width: 100%; max-width: 660px; }
        .ss-mobile-brand { display: none; }
        .ss-form-heading { margin-bottom: 28px; }
        .ss-form-heading .ss-small-label {
            margin: 0 0 11px;
            color: var(--ss-blue);
            font-size: .76rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .ss-form-heading h2 {
            margin: 0;
            color: var(--ss-ink);
            font-size: clamp(2rem, 3.2vw, 2.55rem);
            font-weight: 800;
            letter-spacing: -.055em;
            line-height: 1.15;
        }
        .ss-form-heading > p:last-child { margin: 12px 0 0; color: var(--ss-muted); font-size: .92rem; line-height: 1.65; }

        .ss-form-card {
            padding: clamp(20px, 3vw, 30px);
            border: 1px solid #e8edf7;
            border-radius: 23px;
            background: #fff;
            box-shadow: 0 18px 55px rgba(44, 63, 112, .065);
        }
        .ss-form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px 18px; }
        .ss-field { min-width: 0; }
        .ss-field-full { grid-column: 1 / -1; }
        .ss-label { display: block; margin-bottom: 8px; color: #354364; font-size: .84rem; font-weight: 750; }
        input.ss-input, select.ss-select {
            display: block;
            width: 100%;
            min-height: 49px;
            margin: 0;
            padding: 12px 14px;
            border: 1px solid #dfe5f1 !important;
            border-radius: 12px !important;
            background: #fbfcff !important;
            color: var(--ss-ink) !important;
            box-shadow: none !important;
            font-size: .89rem;
            line-height: 1.4;
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }
        input.ss-input::placeholder { color: #9aa5bb; }
        input.ss-input:focus, select.ss-select:focus {
            border-color: #7891ed !important;
            background: #fff !important;
            outline: none;
            box-shadow: 0 0 0 4px rgba(104, 136, 244, .13) !important;
        }
        .ss-hint { margin: 7px 0 0; color: #8793aa; font-size: .75rem; line-height: 1.5; }
        .ss-error { margin-top: 7px; color: #c24150; font-size: .8rem; }

        .ss-privacy-card {
            margin-top: 24px;
            padding: 17px;
            border: 1px solid #e3e9fb;
            border-radius: 16px;
            background: linear-gradient(135deg, #f8faff, #fbf9ff);
        }
        .ss-privacy-title { display: flex; align-items: center; gap: 9px; margin: 0 0 11px; color: #354364; font-size: .87rem; font-weight: 800; }
        .ss-privacy-title svg { flex: 0 0 auto; color: #657be0; }
        .ss-consent-label { display: flex; align-items: flex-start; gap: 10px; color: #65718a; font-size: .79rem; line-height: 1.7; cursor: pointer; }
        .ss-consent-label input { width: 17px; height: 17px; flex: 0 0 17px; margin: 3px 0 0; accent-color: var(--ss-blue); }
        .ss-privacy-link { display: inline-block; margin: 11px 0 0 27px; color: #5874d8; font-size: .79rem; font-weight: 750; text-decoration: none; }
        .ss-privacy-link:hover { color: #344fb9; text-decoration: underline; }

        .ss-form-actions { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-top: 24px; }
        .ss-login-link { color: #687793; font-size: .83rem; text-decoration: none; }
        .ss-login-link:hover { color: #344fb9; text-decoration: underline; }
        button.ss-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 49px;
            padding: 12px 20px;
            border: 0 !important;
            border-radius: 13px !important;
            background: linear-gradient(110deg, #5f80ec, #7774e3) !important;
            color: #fff !important;
            box-shadow: 0 9px 20px rgba(82, 118, 232, .21) !important;
            font-size: .88rem;
            font-weight: 800;
            white-space: nowrap;
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }
        button.ss-submit:hover { transform: translateY(-1px); filter: brightness(1.03); box-shadow: 0 12px 23px rgba(82,118,232,.27) !important; }
        button.ss-submit:focus-visible { outline: 3px solid rgba(82,118,232,.35); outline-offset: 3px; }
        .ss-bottom-note { display: flex; align-items: flex-start; justify-content: center; gap: 8px; margin-top: 20px; color: #8a96ad; font-size: .76rem; line-height: 1.6; text-align: center; }
        .ss-bottom-note svg { flex: 0 0 auto; margin-top: 1px; }

        @media (max-width: 1000px) {
            .ss-page { grid-template-columns: minmax(250px, .72fr) minmax(0, 1.28fr); }
            .ss-welcome { padding: 30px; }
            .ss-form-side { padding: 32px 25px; }
            .ss-hero h1 { font-size: clamp(2.2rem, 4.5vw, 3rem); }
        }
        @media (max-width: 760px) {
            .ss-page { display: block; }
            .ss-welcome { display: none; }
            .ss-form-side { min-height: 100vh; padding: 26px 18px 36px; }
            .ss-form-wrap { max-width: 620px; }
            .ss-mobile-brand { display: inline-flex; margin-bottom: 32px; }
            .ss-form-heading h2 { font-size: 2.1rem; }
        }
        @media (max-width: 520px) {
            .ss-form-card { padding: 19px 16px; border-radius: 18px; }
            .ss-form-grid { grid-template-columns: minmax(0, 1fr); gap: 18px; }
            .ss-field-full { grid-column: auto; }
            .ss-form-actions { align-items: stretch; flex-direction: column-reverse; }
            .ss-login-link { text-align: center; }
            button.ss-submit { width: 100%; }
            .ss-privacy-card { padding: 14px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
    <main class="ss-page">
        <aside class="ss-welcome" aria-label="About SafeSpace">
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
                <div class="ss-eyebrow"><span class="ss-eyebrow-dot"></span> Start with a safe space</div>
                <h1>A new step<br>toward feeling <span>safe.</span></h1>
                <p>Create your student account to make it easier to reach school support when you need it. You deserve to be heard and treated with respect.</p>

                <div class="ss-benefits">
                    <div class="ss-benefit">
                        <div class="ss-benefit-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 3 19 6v5c0 4.4-2.8 7.6-7 9.5C7.8 18.6 5 15.4 5 11V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div><strong>Your information deserves care</strong><p>Only provide the details requested for your student account and school support.</p></div>
                    </div>
                    <div class="ss-benefit">
                        <div class="ss-benefit-icon" aria-hidden="true" style="background:#f0edff;color:#7a68d7;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5v-15Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M4 5.5v15M8 7h8M8 10.5h7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                        </div>
                        <div><strong>Take the first step</strong><p>When you need help, SafeSpace provides a way to share a concern with the school.</p></div>
                    </div>
                </div>
            </div>

            <div class="ss-footer">SafeSpace · East Central Integrated School</div>
        </aside>

        <section class="ss-form-side" aria-labelledby="register-title">
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
                    <p class="ss-small-label">Student registration</p>
                    <h2 id="register-title">Create your account</h2>
                    <p>Fill in your school details below. Fields marked as required must be completed to register.</p>
                </div>

                <div class="ss-form-card">
                    <!-- Registration route, CSRF protection, field names and validation bindings preserved. -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="ss-form-grid">
                            <!-- LRN -->
                            <div class="ss-field ss-field-full">
                                <x-input-label for="lrn" value="LRN (12 digits)" class="ss-label" />
                                <x-text-input
                                    id="lrn"
                                    class="ss-input"
                                    type="text"
                                    name="lrn"
                                    :value="old('lrn')"
                                    required
                                    autofocus
                                    maxlength="12"
                                    minlength="12"
                                    inputmode="numeric"
                                    pattern="[0-9]{12}"
                                    autocomplete="username"
                                    placeholder="Enter your 12-digit learner reference number"
                                />
                                <p class="ss-hint">Use the 12-digit LRN provided by your school.</p>
                                <x-input-error :messages="$errors->get('lrn')" class="ss-error" />
                            </div>

                            <!-- First Name -->
                            <div class="ss-field">
                                <x-input-label for="first_name" value="First Name" class="ss-label" />
                                <x-text-input
                                    id="first_name"
                                    class="ss-input"
                                    type="text"
                                    name="first_name"
                                    :value="old('first_name')"
                                    required
                                    autocomplete="given-name"
                                    placeholder="Your first name"
                                />
                                <x-input-error :messages="$errors->get('first_name')" class="ss-error" />
                            </div>

                            <!-- Last Name -->
                            <div class="ss-field">
                                <x-input-label for="last_name" value="Last Name" class="ss-label" />
                                <x-text-input
                                    id="last_name"
                                    class="ss-input"
                                    type="text"
                                    name="last_name"
                                    :value="old('last_name')"
                                    required
                                    autocomplete="family-name"
                                    placeholder="Your last name"
                                />
                                <x-input-error :messages="$errors->get('last_name')" class="ss-error" />
                            </div>

                            <!-- Grade Level -->
                            <div class="ss-field">
                                <x-input-label for="grade_level" value="Grade Level" class="ss-label" />
                                <select id="grade_level" name="grade_level" required class="ss-select">
                                    <option value="">Select grade</option>
                                    @foreach ([7, 8, 9, 10, 11, 12] as $grade)
                                        <option value="{{ $grade }}" @selected(old('grade_level') == $grade)>Grade {{ $grade }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('grade_level')" class="ss-error" />
                            </div>

                            <!-- Section -->
                            <div class="ss-field">
                                <x-input-label for="section" value="Section" class="ss-label" />
                                <x-text-input
                                    id="section"
                                    class="ss-input"
                                    type="text"
                                    name="section"
                                    :value="old('section')"
                                    required
                                    autocomplete="off"
                                    placeholder="Your class section"
                                />
                                <x-input-error :messages="$errors->get('section')" class="ss-error" />
                            </div>

                            <!-- Password -->
                            <div class="ss-field">
                                <x-input-label for="password" value="Password" class="ss-label" />
                                <x-text-input
                                    id="password"
                                    class="ss-input"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Create a password"
                                />
                                <x-input-error :messages="$errors->get('password')" class="ss-error" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="ss-field">
                                <x-input-label for="password_confirmation" value="Confirm Password" class="ss-label" />
                                <x-text-input
                                    id="password_confirmation"
                                    class="ss-input"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Enter your password again"
                                />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="ss-error" />
                            </div>
                        </div>

                        <!-- Privacy Notice and consent field preserved -->
                        <div class="ss-privacy-card">
                            <h3 class="ss-privacy-title">
                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="5" y="10" width="14" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/>
                                    <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                                Your privacy matters
                            </h3>
                            <label for="privacy_consent" class="ss-consent-label">
                                <input id="privacy_consent" type="checkbox" name="privacy_consent" value="1" required>
                                <span>I agree that SafeSpace may collect my LRN, name, grade, and section, and the reports I submit, for handling bullying incidents. Only the guidance counselor can see my information, in accordance with the Data Privacy Act (RA 10173).</span>
                            </label>
                            <x-input-error :messages="$errors->get('privacy_consent')" class="ss-error" />
                            <a href="{{ route('privacy') }}" target="_blank" rel="noopener noreferrer" class="ss-privacy-link">Read the full privacy notice <span aria-hidden="true">↗</span></a>
                        </div>

                        <div class="ss-form-actions">
                            <a class="ss-login-link" href="{{ route('login') }}">Already registered? <strong>Log in</strong></a>
                            <x-primary-button class="ss-submit">
                                Create account
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <div class="ss-bottom-note">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="5" y="10" width="14" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                    <span>Keep your login details private. If you need help, contact the appropriate school support personnel.</span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
