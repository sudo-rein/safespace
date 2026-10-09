<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SafeSpace | A safe place to speak up</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --ink: #243052;
            --muted: #69738f;
            --blue: #6178e8;
            --blue-dark: #455bd0;
            --lavender: #eeeaff;
            --mint: #e4f8f2;
            --peach: #fff0e7;
            --line: #e9ecf5;
            --white: #ffffff;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            background: #fbfbff;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        button, a { -webkit-tap-highlight-color: transparent; }
        .site-shell { overflow: hidden; }
        .container { width: min(1140px, calc(100% - 44px)); margin: 0 auto; }

        .topbar {
            position: relative;
            z-index: 5;
            background: rgba(255,255,255,.88);
            border-bottom: 1px solid rgba(233,236,245,.85);
            backdrop-filter: blur(14px);
        }
        .nav {
            min-height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }
        .brand { display: inline-flex; align-items: center; gap: 11px; font-weight: 850; letter-spacing: -.7px; font-size: 1.25rem; }
        .brand-mark {
            width: 42px; height: 42px; border-radius: 15px;
            display: grid; place-items: center;
            color: white; background: linear-gradient(145deg, #8394ff, #6573e9);
            box-shadow: 0 8px 18px rgba(97,120,232,.24);
        }
        .brand-mark svg { width: 23px; height: 23px; }
        .brand span { color: var(--blue); }
        .nav-links { display: flex; align-items: center; gap: 28px; color: #626c88; font-size: .92rem; font-weight: 650; }
        .nav-links a:not(.button):hover { color: var(--blue-dark); }
        .nav-actions { display: flex; align-items: center; gap: 12px; }
        .button {
            display: inline-flex; align-items: center; justify-content: center; gap: 9px;
            padding: 13px 19px; min-height: 46px;
            border-radius: 14px; border: 1px solid transparent;
            font: inherit; font-size: .94rem; font-weight: 750;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
            cursor: pointer;
        }
        .button:hover { transform: translateY(-2px); }
        .button-primary { background: var(--blue); color: white; box-shadow: 0 9px 20px rgba(97,120,232,.23); }
        .button-primary:hover { background: var(--blue-dark); box-shadow: 0 12px 24px rgba(97,120,232,.3); }
        .button-outline { background: white; color: var(--ink); border-color: #e1e5f1; }
        .button-outline:hover { border-color: #bcc5f7; background: #fafaff; }
        .button-light { background: white; color: var(--blue-dark); box-shadow: 0 8px 20px rgba(40,54,100,.1); }
        .mobile-nav { display: none; }

        .hero {
            position: relative;
            padding: 78px 0 88px;
            background:
                radial-gradient(ellipse at 7% 8%, rgba(224,220,255,.62), transparent 29%),
                radial-gradient(ellipse at 94% 56%, rgba(215,246,239,.65), transparent 27%),
                linear-gradient(180deg, #fbfbff 0%, #f7f8ff 100%);
        }
        .hero-grid { display: grid; grid-template-columns: 1.02fr .98fr; gap: 65px; align-items: center; }
        .eyebrow {
            width: fit-content; display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 13px; border-radius: 999px; color: #5b68c9;
            background: #eeefff; border: 1px solid #e3e5ff;
            font-size: .79rem; font-weight: 800; letter-spacing: .15px;
        }
        .eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: #7d88ef; box-shadow: 0 0 0 4px rgba(125,136,239,.13); }
        .hero h1 { margin: 22px 0 19px; max-width: 620px; font-size: clamp(2.8rem, 5.2vw, 4.65rem); line-height: 1.04; letter-spacing: -3.5px; font-weight: 850; }
        .hero h1 .highlight { color: var(--blue); position: relative; white-space: nowrap; }
        .hero-copy { max-width: 520px; margin: 0; color: var(--muted); font-size: 1.08rem; line-height: 1.85; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 29px; }
        .hero-note { margin-top: 19px; display: flex; align-items: center; gap: 9px; color: #7b849c; font-size: .84rem; line-height: 1.5; }
        .hero-note svg { flex: 0 0 auto; color: #5f8a7d; }

        .visual-wrap { min-height: 430px; display: grid; place-items: center; position: relative; }
        .orb { position: absolute; border-radius: 50%; pointer-events: none; }
        .orb-one { width: 320px; height: 320px; background: #eae8ff; top: 36px; right: 30px; }
        .orb-two { width: 76px; height: 76px; background: #d8f5ed; bottom: 27px; left: 12px; }
        .sparkle { position: absolute; color: #8994f4; font-size: 2rem; font-weight: 800; }
        .sparkle-a { right: 4px; top: 50px; transform: rotate(12deg); }
        .sparkle-b { left: 28px; top: 70px; font-size: 1.4rem; color: #e9a77e; }
        .report-card {
            position: relative; z-index: 1; width: min(100%, 390px);
            background: rgba(255,255,255,.94); border: 1px solid rgba(226,230,246,.96);
            border-radius: 27px; padding: 25px; box-shadow: 0 24px 70px rgba(52,64,125,.13);
            transform: rotate(1.2deg);
        }
        .card-head { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 22px; }
        .card-title { display: flex; align-items: center; gap: 11px; font-weight: 800; font-size: .98rem; }
        .card-icon { width: 42px; height: 42px; display: grid; place-items: center; border-radius: 14px; background: var(--lavender); color: #6673d9; }
        .card-icon svg { width: 21px; height: 21px; }
        .tiny-label { display: inline-flex; align-items: center; gap: 6px; color: #73809b; background: #f5f6fc; border-radius: 999px; padding: 7px 10px; font-size: .69rem; font-weight: 800; }
        .tiny-label i { width: 6px; height: 6px; border-radius: 50%; background: #76b9a4; }
        .field-label { display: block; color: #68738f; font-size: .75rem; font-weight: 800; margin: 15px 0 7px; }
        .fake-input { min-height: 43px; border: 1px solid #e8ebf5; border-radius: 11px; padding: 12px; color: #8490a8; font-size: .8rem; background: #fdfdff; }
        .fake-input.message { min-height: 73px; line-height: 1.65; }
        .tag-row { display: flex; flex-wrap: wrap; gap: 7px; }
        .tag { font-size: .7rem; font-weight: 750; border-radius: 999px; padding: 7px 10px; color: #6571cb; background: #efefff; }
        .tag.mint { color: #41816e; background: #e8f8f1; }
        .fake-submit { width: 100%; border-radius: 12px; margin-top: 20px; padding: 13px; text-align: center; font-size: .81rem; font-weight: 800; color: #fff; background: linear-gradient(100deg, #7687f0, #6676e7); }
        .floating-note { position: absolute; z-index: 2; display: flex; align-items: center; gap: 10px; border: 1px solid #eef0f8; background: white; padding: 12px 15px; border-radius: 16px; box-shadow: 0 14px 35px rgba(45,58,112,.12); font-size: .77rem; font-weight: 800; }
        .floating-note svg { width: 21px; height: 21px; color: #6b9d8a; }
        .floating-note small { display: block; font-size: .67rem; color: #8a93a8; font-weight: 600; margin-top: 3px; }
        .note-top { top: 18px; left: 0; transform: rotate(-4deg); }
        .note-bottom { bottom: 24px; right: -9px; transform: rotate(3deg); }

        .section { padding: 83px 0; }
        .section-heading { max-width: 660px; margin: 0 auto 43px; text-align: center; }
        .section-kicker { color: #6b78d9; font-size: .77rem; font-weight: 850; text-transform: uppercase; letter-spacing: 1.6px; }
        .section-heading h2 { margin: 12px 0 13px; font-size: clamp(2rem, 3.2vw, 2.8rem); line-height: 1.15; letter-spacing: -1.5px; }
        .section-heading p { margin: 0; color: var(--muted); line-height: 1.8; }
        .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 19px; }
        .feature-card { background: white; border: 1px solid var(--line); padding: 27px; border-radius: 22px; box-shadow: 0 8px 24px rgba(36,48,82,.025); transition: transform .2s ease, box-shadow .2s ease; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 18px 32px rgba(36,48,82,.07); }
        .feature-icon { width: 51px; height: 51px; display: grid; place-items: center; border-radius: 17px; margin-bottom: 21px; }
        .feature-icon svg { width: 24px; height: 24px; }
        .feature-icon.lavender { background: var(--lavender); color: #6874dc; }
        .feature-icon.mint { background: var(--mint); color: #478b78; }
        .feature-icon.peach { background: var(--peach); color: #c47c55; }
        .feature-card h3 { margin: 0 0 9px; font-size: 1.05rem; letter-spacing: -.25px; }
        .feature-card p { margin: 0; color: var(--muted); font-size: .91rem; line-height: 1.8; }

        .steps-section { background: #f3f5ff; border-top: 1px solid #eceeff; border-bottom: 1px solid #eceeff; }
        .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .step { text-align: center; padding: 0 17px; }
        .step-number { width: 49px; height: 49px; border-radius: 17px; display: grid; place-items: center; margin: 0 auto 17px; background: white; color: var(--blue-dark); font-size: 1.03rem; font-weight: 850; box-shadow: 0 7px 18px rgba(65,78,157,.09); }
        .step h3 { margin: 0 0 9px; font-size: 1.03rem; }
        .step p { margin: 0; color: var(--muted); font-size: .9rem; line-height: 1.8; }

        .cta-section { padding: 78px 0; }
        .cta-panel { position: relative; isolation: isolate; overflow: hidden; display: flex; align-items: center; justify-content: space-between; gap: 35px; padding: 44px 48px; border-radius: 28px; background: linear-gradient(115deg, #6577e6, #8c8aee); color: white; box-shadow: 0 20px 50px rgba(99,112,220,.2); }
        .cta-panel::before, .cta-panel::after { content: ""; position: absolute; z-index: -1; border: 1px solid rgba(255,255,255,.16); border-radius: 50%; }
        .cta-panel::before { width: 280px; height: 280px; right: 80px; top: -180px; }
        .cta-panel::after { width: 190px; height: 190px; right: -50px; bottom: -140px; }
        .cta-panel h2 { max-width: 570px; margin: 0 0 10px; font-size: clamp(1.7rem, 3vw, 2.35rem); line-height: 1.18; letter-spacing: -1px; }
        .cta-panel p { max-width: 600px; margin: 0; color: rgba(255,255,255,.84); line-height: 1.75; font-size: .95rem; }
        .cta-panel .button { flex-shrink: 0; }
        .footer { border-top: 1px solid var(--line); padding: 27px 0; background: white; }
        .footer-inner { display: flex; justify-content: space-between; align-items: center; gap: 18px; color: #8991a6; font-size: .81rem; }
        .footer-brand { display: inline-flex; align-items: center; gap: 8px; color: var(--ink); font-weight: 850; }
        .footer-brand .brand-mark { width: 30px; height: 30px; border-radius: 10px; box-shadow: none; }
        .footer-brand .brand-mark svg { width: 17px; height: 17px; }

        @media (max-width: 960px) {
            .hero-grid { gap: 30px; }
            .hero h1 { letter-spacing: -2.4px; }
            .nav-links { gap: 17px; }
            .visual-wrap { min-height: 390px; }
            .orb-one { width: 275px; height: 275px; right: 16px; }
            .report-card { width: min(100%, 355px); padding: 21px; }
            .note-bottom { right: -2px; }
        }
        @media (max-width: 760px) {
            .container { width: min(100% - 32px, 560px); }
            .nav { min-height: 72px; }
            .nav-links { display: none; }
            .nav-actions .button-outline { display: none; }
            .nav-actions .button { min-height: 41px; padding: 10px 13px; font-size: .84rem; }
            .mobile-nav { display: block; padding: 0 0 15px; }
            .mobile-nav details { border-top: 1px solid var(--line); padding-top: 12px; }
            .mobile-nav summary { color: #69738f; font-size: .88rem; font-weight: 750; cursor: pointer; }
            .mobile-menu-links { display: grid; gap: 12px; padding: 13px 0 5px; color: #69738f; font-size: .9rem; font-weight: 650; }
            .hero { padding: 51px 0 52px; }
            .hero-grid { grid-template-columns: 1fr; gap: 22px; }
            .hero h1 { font-size: clamp(2.7rem, 11vw, 4rem); letter-spacing: -2.5px; }
            .hero-copy { font-size: 1rem; }
            .visual-wrap { min-height: 390px; margin: 0 -5px; }
            .orb-one { width: 275px; height: 275px; top: 48px; right: 50%; transform: translateX(50%); }
            .report-card { width: min(100% - 28px, 365px); }
            .note-top { left: 0; top: 18px; }
            .note-bottom { right: -1px; bottom: 12px; }
            .section { padding: 63px 0; }
            .section-heading { margin-bottom: 30px; }
            .feature-grid, .steps-grid { grid-template-columns: 1fr; gap: 14px; }
            .feature-card { padding: 23px; }
            .steps-grid { gap: 27px; }
            .step { padding: 0 9px; }
            .cta-section { padding: 54px 0; }
            .cta-panel { padding: 31px 25px; align-items: flex-start; flex-direction: column; border-radius: 23px; gap: 23px; }
            .cta-panel .button { width: 100%; }
            .footer-inner { align-items: flex-start; flex-direction: column; gap: 11px; }
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after { transition-duration: .01ms !important; animation-duration: .01ms !important; }
        }
    </style>
</head>
<body>
<div class="site-shell">
    <header class="topbar">
        <div class="container">
            <nav class="nav" aria-label="Main navigation">
                <a class="brand" href="{{ url('/') }}" aria-label="SafeSpace home">
                    <span class="brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 20.1s-7.5-4.35-7.5-10.05A4.15 4.15 0 0 1 12 7.8a4.15 4.15 0 0 1 7.5 2.25c0 5.7-7.5 10.05-7.5 10.05Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.4 12.1h2.1l1.1-2.2 1.5 4 1.1-1.8h1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <span>Safe<span>Space</span></span>
                </a>

                <div class="nav-links">
                    <a href="#about">About SafeSpace</a>
                    <a href="#how-it-works">How it works</a>
                    <a href="#support">Support</a>
                </div>

                <div class="nav-actions">
                    <a class="button button-outline" href="{{ route('login') }}">Log in</a>
                    <a class="button button-primary" href="{{ route('register') }}">Get started <span aria-hidden="true">→</span></a>
                </div>
            </nav>
            <div class="mobile-nav">
                <details>
                    <summary>Explore SafeSpace</summary>
                    <div class="mobile-menu-links">
                        <a href="#about">About SafeSpace</a>
                        <a href="#how-it-works">How it works</a>
                        <a href="#support">Support</a>
                        <a href="{{ route('login') }}">Log in</a>
                    </div>
                </details>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-grid">
                <div class="hero-content">
                    <div class="eyebrow"><span class="eyebrow-dot"></span> A kinder school starts with listening</div>
                    <h1>You deserve to feel <span class="highlight">safe</span> at school.</h1>
                    <p class="hero-copy">Having a difficult experience? SafeSpace gives students a simple way to speak up about bullying and ask for support from the people who can help.</p>
                    <div class="hero-actions">
                        <a class="button button-primary" href="{{ route('login') }}">Speak up <span aria-hidden="true">→</span></a>
                        <a class="button button-outline" href="#how-it-works">See how it works</a>
                    </div>
                    <div class="hero-note">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Your concern matters. You don't have to figure it out alone.
                    </div>
                </div>

                <div class="visual-wrap" aria-label="Illustration of a student-friendly incident report" role="img">
                    <div class="orb orb-one"></div>
                    <div class="orb orb-two"></div>
                    <span class="sparkle sparkle-a" aria-hidden="true">✳</span>
                    <span class="sparkle sparkle-b" aria-hidden="true">✦</span>
                    <div class="floating-note note-top">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 21s-7-4.2-7-10V5l7-2 7 2v6c0 5.8-7 10-7 10Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <div>You're being heard<small>One step at a time</small></div>
                    </div>
                    <div class="report-card" aria-hidden="true">
                        <div class="card-head">
                            <div class="card-title">
                                <span class="card-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M7 3.75h7l4 4V20a.75.75 0 0 1-.75.75h-10.5A.75.75 0 0 1 6 20V4.5a.75.75 0 0 1 .75-.75Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M14 4v4h4M9 12h6M9 15.5h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
                                Incident report
                            </div>
                            <span class="tiny-label"><i></i> Guided form</span>
                        </div>
                        <span class="field-label">What would you like to share?</span>
                        <div class="fake-input message">You can describe what happened in your own words. Take your time.</div>
                        <span class="field-label">Where did it happen?</span>
                        <div class="tag-row"><span class="tag">Classroom</span><span class="tag mint">School grounds</span><span class="tag">Online</span></div>
                        <div class="fake-submit">Continue when you're ready <span>→</span></div>
                    </div>
                    <div class="floating-note note-bottom">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3.5a8.5 8.5 0 0 0-7.2 13l-.8 4 4-.9A8.5 8.5 0 1 0 12 3.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8.5 12h7M12 8.5v7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                        <div>Support is available<small>You deserve to be listened to</small></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="about">
            <div class="container">
                <div class="section-heading">
                    <span class="section-kicker">A space for students</span>
                    <h2>Speak up in a way that feels right for you.</h2>
                    <p>Starting a conversation can be difficult. SafeSpace helps make the first step clearer, simpler, and less intimidating.</p>
                </div>
                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon lavender"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 12h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
                        <h3>Your voice matters</h3>
                        <p>Share a concern in your own words. You don't need to know exactly what to call the situation before asking for help.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon mint"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 4.75h14A1.25 1.25 0 0 1 20.25 6v10A1.25 1.25 0 0 1 19 17.25h-8L5 20V5.5c0-.41.34-.75.75-.75Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8.5 9h7M8.5 12.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
                        <h3>Clear, guided reporting</h3>
                        <p>Simple prompts help you explain what happened, when it happened, and what kind of support you may need.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon peach"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 18.5V20M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM16 8h5M18.5 5.5v5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                        <h3>Support from school staff</h3>
                        <p>Authorized school personnel can review submitted concerns and decide on appropriate next steps with care.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section steps-section" id="how-it-works">
            <div class="container">
                <div class="section-heading">
                    <span class="section-kicker">One step at a time</span>
                    <h2>Getting support can start here.</h2>
                    <p>You can take things at your own pace. Here's what the reporting process generally looks like.</p>
                </div>
                <div class="steps-grid">
                    <article class="step">
                        <div class="step-number">01</div>
                        <h3>Tell us what happened</h3>
                        <p>Sign in and use the reporting form to share the details you're comfortable providing.</p>
                    </article>
                    <article class="step">
                        <div class="step-number">02</div>
                        <h3>Your concern is reviewed</h3>
                        <p>The system may assist with preliminary risk prioritization, while authorized staff review the report.</p>
                    </article>
                    <article class="step">
                        <div class="step-number">03</div>
                        <h3>Support and follow-up</h3>
                        <p>School personnel can assess the situation and determine what follow-up or support is appropriate.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="cta-section" id="support">
            <div class="container">
                <div class="cta-panel">
                    <div>
                        <h2>You don't have to handle a difficult situation by yourself.</h2>
                        <p>Whenever you're ready, SafeSpace can help you start sharing your concern with the appropriate school personnel.</p>
                    </div>
                    <a class="button button-light" href="{{ route('login') }}">Go to SafeSpace <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <a class="footer-brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 20.1s-7.5-4.35-7.5-10.05A4.15 4.15 0 0 1 12 7.8a4.15 4.15 0 0 1 7.5 2.25c0 5.7-7.5 10.05-7.5 10.05Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                SafeSpace
            </a>
            <span>Made to help students feel heard.</span>
            <span>© {{ date('Y') }} SafeSpace</span>
        </div>
    </footer>
</div>
</body>
</html>
