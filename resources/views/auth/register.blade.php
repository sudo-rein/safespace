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
        .ss-page { min-height: 100vh; display: grid; grid-template-columns: minmax(300px, .84fr) minmax(0, 1.16fr); align-items: start; }
        .ss-welcome {
            position: sticky; top: 0; isolation: isolate; overflow: hidden; display: flex; flex-direction: column;
            justify-content: space-between; align-self: start; height: 100vh; min-height: 650px;
            padding: clamp(30px, 4.5vw, 62px); color: #fff;
            background: linear-gradient(150deg, var(--ss-navy) 0%, #1d3268 52%, #243c79 100%);
        }
        .ss-welcome::before, .ss-welcome::after {
            content: ""; position: absolute; z-index: -1; border: 1px solid rgba(255,255,255,.085); border-radius: 50%; pointer-events: none;
        }
        .ss-welcome::before { width: 520px; height: 520px; left: -300px; top: 8%; box-shadow: 0 0 0 42px rgba(255,255,255,.018), 0 0 0 92px rgba(255,255,255,.014); }
        .ss-welcome::after { width: 410px; height: 410px; right: -260px; bottom: -160px; box-shadow: 0 0 0 35px rgba(255,255,255,.02), 0 0 0 75px rgba(255,255,255,.015); }
        .ss-brand { display: inline-flex; align-items: center; gap: 12px; width: fit-content; position: relative; z-index: 1; }
        .ss-brand-mark { display: grid; place-items: center; width: 47px; height: 47px; flex: 0 0 47px; border-radius: 14px; color: #fff; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.13); box-shadow: 0 8px 24px rgba(5,13,38,.14); }
        .ss-brand-name { color: #fff; font-size: 1.25rem; font-weight: 850; letter-spacing: -.045em; }
        .ss-brand-caption { margin-top: 3px; color: #c7d2ee; font-size: .76rem; }
        .ss-hero { max-width: 490px; margin: 42px 0; position: relative; z-index: 1; }
        .ss-eyebrow { display: inline-flex; align-items: center; gap: 9px; padding: 8px 12px; border: 1px solid rgba(255,255,255,.13); border-radius: 999px; background: rgba(255,255,255,.075); color: #e3eaff; font-size: .75rem; font-weight: 750; letter-spacing: .02em; }
        .ss-eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: #a2ecd0; box-shadow: 0 0 0 4px rgba(162,236,208,.1); }
        .ss-hero h1 { margin: 24px 0 17px; color: #fff; font-size: clamp(2.35rem, 4vw, 3.65rem); font-weight: 850; line-height: 1.05; letter-spacing: -.06em; }
        .ss-hero h1 span { color: var(--ss-gold); }
        .ss-hero > p { margin: 0; color: #d8e1f7; font-size: .94rem; line-height: 1.8; }
        .ss-benefits { display: grid; gap: 11px; margin-top: 25px; }
        .ss-benefit { display: flex; align-items: flex-start; gap: 11px; padding: 13px; border: 1px solid rgba(255,255,255,.12); border-radius: 14px; background: rgba(255,255,255,.065); }
        .ss-benefit-icon { display: grid; place-items: center; width: 34px; height: 34px; flex: 0 0 34px; border-radius: 10px; background: rgba(162,236,208,.13) !important; color: #a2ecd0 !important; }
        .ss-benefit strong { display: block; margin: 1px 0 3px; color: #fff; font-size: .82rem; }
        .ss-benefit p { margin: 0; color: #c7d2ec; font-size: .75rem; line-height: 1.55; }
        .ss-footer { color: #b9c7e7; font-size: .75rem; position: relative; z-index: 1; }
        .ss-form-side { display: flex; align-items: flex-start; justify-content: center; min-width: 0; min-height: 100vh; padding: clamp(28px, 4.3vw, 60px); background: #fff; }
        .ss-form-wrap { width: 100%; max-width: 660px; }
        .ss-mobile-brand { display: none; }
        .ss-form-heading { margin-bottom: 27px; }
        .ss-form-heading .ss-small-label { margin: 0 0 10px; color: var(--ss-navy); font-size: .74rem; font-weight: 850; letter-spacing: .11em; text-transform: uppercase; }
        .ss-form-heading h2 { margin: 0; color: #101a30; font-size: clamp(2rem, 3vw, 2.5rem); font-weight: 850; letter-spacing: -.055em; line-height: 1.15; }
        .ss-form-heading > p:last-child { margin: 11px 0 0; color: var(--ss-muted); font-size: .9rem; line-height: 1.65; }
        .ss-form-card { padding: 0; border: 0; border-radius: 0; background: transparent; box-shadow: none; }
        .ss-form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 17px 16px; }
        .ss-field { min-width: 0; }
        .ss-field-full { grid-column: 1 / -1; }
        .ss-label { display: block; margin-bottom: 7px; color: #253453; font-size: .81rem; font-weight: 750; }
        input.ss-input, select.ss-select {
            display: block; width: 100%; min-height: 46px; margin: 0; padding: 11px 13px;
            border: 1px solid #cfd8ed !important; border-radius: 10px !important; background: #fff !important;
            color: var(--ss-ink) !important; box-shadow: none !important; font-size: .86rem; line-height: 1.4;
            transition: border-color .18s ease, box-shadow .18s ease;
        }
        input.ss-input::placeholder { color: #97a3b8; }
        input.ss-input:focus, select.ss-select:focus { border-color: #8297d9 !important; outline: none; box-shadow: 0 0 0 3px rgba(83,110,208,.12) !important; }
        .ss-hint { margin: 6px 0 0; color: #8793aa; font-size: .73rem; line-height: 1.5; }
        .ss-error { margin-top: 6px; color: #bd354a; font-size: .78rem; }
        .ss-privacy-card { margin-top: 21px; padding: 15px 16px; border: 1px solid #e2e7f0; border-radius: 13px; background: #f7f9fd; }
        .ss-privacy-title { display: flex; align-items: center; gap: 8px; margin: 0 0 9px; color: #253453; font-size: .83rem; font-weight: 800; }
        .ss-privacy-title svg { flex: 0 0 auto; color: var(--ss-navy); }
        .ss-consent-label { display: flex; align-items: flex-start; gap: 9px; color: #63708a; font-size: .75rem; line-height: 1.65; cursor: pointer; }
        .ss-consent-label input { width: 16px; height: 16px; flex: 0 0 16px; margin: 3px 0 0; accent-color: var(--ss-navy); }
        .ss-privacy-link { display: inline-block; margin: 9px 0 0 25px; color: var(--ss-navy); font-size: .76rem; font-weight: 750; text-decoration: none; }
        .ss-privacy-link:hover { color: #3e5798; text-decoration: underline; }
        .ss-form-actions { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-top: 22px; }
        .ss-login-link { color: #68758d; font-size: .81rem; text-decoration: none; }
        .ss-login-link strong { color: var(--ss-navy); }
        .ss-login-link:hover { color: #3e5798; text-decoration: underline; }
        button.ss-submit { display: inline-flex; align-items: center; justify-content: center; gap: 9px; min-height: 46px; padding: 11px 18px; border: 0 !important; border-radius: 10px !important; background: var(--ss-navy) !important; color: #fff !important; box-shadow: 0 7px 16px rgba(27,47,99,.14) !important; font-size: .85rem; font-weight: 800; white-space: nowrap; transition: transform .18s ease, box-shadow .18s ease, background .18s ease; }
        button.ss-submit:hover { transform: translateY(-1px); background: #263f7d !important; box-shadow: 0 10px 19px rgba(27,47,99,.2) !important; }
        button.ss-submit:focus-visible { outline: 3px solid rgba(83,110,208,.35); outline-offset: 3px; }
        .ss-bottom-note { display: flex; align-items: flex-start; justify-content: center; gap: 8px; margin: 18px auto 0; color: #8994a8; font-size: .74rem; line-height: 1.6; text-align: center; }
        .ss-bottom-note svg { flex: 0 0 auto; margin-top: 1px; }
        @media (max-width: 1050px) {
            .ss-page { grid-template-columns: minmax(270px, .8fr) minmax(0, 1.2fr); }
            .ss-welcome { padding: 30px; }
            .ss-form-side { padding: 32px 28px; }
            .ss-hero h1 { font-size: clamp(2.1rem, 3.8vw, 3rem); }
        }
        @media (max-width: 760px) {
            .ss-page { display: block; }
            .ss-welcome { display: none; }
            .ss-form-side { min-height: 100vh; padding: 26px 20px 34px; }
            .ss-form-wrap { max-width: 650px; }
            .ss-mobile-brand { display: inline-flex; margin-bottom: 29px; }
            .ss-mobile-brand .ss-brand-mark { background: var(--ss-navy); }
            .ss-mobile-brand .ss-brand-name { color: var(--ss-navy); }
            .ss-mobile-brand .ss-brand-caption { color: #7d899f; }
            .ss-form-heading h2 { font-size: 2.1rem; }
        }
        @media (max-width: 540px) {
            .ss-form-grid { grid-template-columns: minmax(0, 1fr); gap: 15px; }
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
