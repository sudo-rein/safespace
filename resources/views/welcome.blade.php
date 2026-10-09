<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#1b2f63">
    <title>SafeSpace | A safe place to speak up</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy: #1b2f63;
            --navy-deep: #14254f;
            --navy-soft: #2a4279;
            --blue: #526ed7;
            --blue-bright: #7187ed;
            --blue-pale: #edf1ff;
            --ink: #1e2b49;
            --muted: #6e7890;
            --line: #e8ecf4;
            --panel: #f7f8fc;
            --white: #fff;
            --mint: #d9f4e9;
            --gold: #ffd45a;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; scroll-padding-top: 24px; }
        body {
            margin: 0;
            color: var(--ink);
            background: #fff;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        a, button { -webkit-tap-highlight-color: transparent; }
        a:focus-visible, summary:focus-visible { outline: 3px solid #8ca0ff; outline-offset: 4px; }
        .page-shell { overflow: hidden; }
        .split-hero { min-height: 690px; min-height: min(790px, 100svh); display: grid; grid-template-columns: minmax(340px, .84fr) minmax(0, 1.16fr); }
        .brand-panel {
            position: relative; display: flex; flex-direction: column; justify-content: space-between;
            min-height: 690px; padding: clamp(30px, 5vw, 66px) clamp(28px, 7.5vw, 112px);
            overflow: hidden; color: #fff; isolation: isolate;
            background: linear-gradient(150deg, var(--navy) 0%, #1d3268 52%, #233b76 100%);
        }
        .brand-panel::before, .brand-panel::after { content: ""; position: absolute; z-index: -1; border: 1px solid rgba(255,255,255,.08); border-radius: 50%; pointer-events: none; }
        .brand-panel::before { width: 510px; height: 510px; top: 8%; left: -290px; box-shadow: 0 0 0 42px rgba(255,255,255,.018), 0 0 0 92px rgba(255,255,255,.014); }
        .brand-panel::after { width: 390px; height: 390px; right: -250px; bottom: -150px; box-shadow: 0 0 0 35px rgba(255,255,255,.022), 0 0 0 74px rgba(255,255,255,.015); }
        .brand { display: inline-flex; align-items: center; gap: 12px; width: fit-content; color: white; font-weight: 850; font-size: 1.22rem; letter-spacing: -.65px; }
        .brand-symbol { width: 47px; height: 47px; display: grid; place-items: center; color: #fff; border: 1px solid rgba(255,255,255,.18); border-radius: 15px; background: rgba(255,255,255,.13); box-shadow: 0 8px 25px rgba(3,12,37,.12); }
        .brand-symbol svg { width: 25px; height: 25px; }
        .brand-word span { color: var(--gold); }
        .panel-main { width: min(100%, 520px); padding: 74px 0 68px; }
        .panel-kicker { display: inline-flex; align-items: center; gap: 9px; padding: 8px 12px; color: #e1e7ff; background: rgba(255,255,255,.085); border: 1px solid rgba(255,255,255,.11); border-radius: 999px; font-size: .76rem; font-weight: 750; letter-spacing: .35px; }
        .live-dot { width: 7px; height: 7px; background: #a2ecd0; border-radius: 50%; box-shadow: 0 0 0 4px rgba(162,236,208,.12); }
        .panel-main h1 { max-width: 520px; margin: 25px 0 18px; color: #fff; font-size: clamp(2.65rem, 4.4vw, 4.45rem); line-height: 1.04; letter-spacing: -.055em; font-weight: 850; }
        .panel-main h1 span { color: var(--gold); }
        .panel-description { max-width: 450px; margin: 0; color: #d9e1f7; font-size: 1rem; line-height: 1.9; }
        .panel-points { display: grid; gap: 13px; margin: 31px 0 0; padding: 0; list-style: none; }
        .panel-points li { display: flex; align-items: center; gap: 12px; color: #f2f5ff; font-size: .91rem; font-weight: 650; }
        .point-icon { width: 28px; height: 28px; flex: 0 0 auto; display: grid; place-items: center; color: #bfeedd; background: rgba(190,238,221,.12); border: 1px solid rgba(190,238,221,.12); border-radius: 9px; }
        .point-icon svg { width: 15px; height: 15px; }
        .panel-bottom { display: flex; justify-content: space-between; align-items: end; gap: 18px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,.14); color: #c0cbe9; font-size: .76rem; line-height: 1.7; }
        .panel-bottom strong { display: block; margin-bottom: 3px; color: white; font-size: .7rem; letter-spacing: 1.15px; text-transform: uppercase; }
        .panel-bottom .bottom-tag { display: inline-flex; align-items: center; gap: 8px; max-width: 210px; text-align: right; }
        .bottom-tag svg { flex: 0 0 auto; width: 22px; height: 22px; color: #d5e0ff; }

        .welcome-panel { display: flex; flex-direction: column; min-width: 0; padding: 32px clamp(28px, 5.8vw, 84px) 27px; background: #fff; }
        .top-nav { display: flex; justify-content: flex-end; align-items: center; gap: 24px; min-height: 47px; color: #68738b; font-size: .83rem; font-weight: 650; }
        .top-nav a:not(.button):hover { color: var(--blue); }
        .button { display: inline-flex; justify-content: center; align-items: center; gap: 10px; min-height: 46px; padding: 12px 18px; border: 1px solid transparent; border-radius: 11px; font-family: inherit; font-size: .88rem; font-weight: 750; transition: transform .18s ease, background .18s ease, box-shadow .18s ease, border-color .18s ease; cursor: pointer; }
        .button:hover { transform: translateY(-2px); }
        .button svg { width: 17px; height: 17px; }
        .button-navy { color: #fff; background: var(--navy); box-shadow: 0 7px 17px rgba(27,47,99,.13); }
        .button-navy:hover { background: #263f7d; box-shadow: 0 10px 20px rgba(27,47,99,.17); }
        .button-soft { color: var(--navy); background: #fff; border-color: #dfe5f1; }
        .button-soft:hover { border-color: #bbc8ef; background: #f8faff; }
        .welcome-content { width: min(100%, 600px); margin: auto; padding: 52px 0 44px; }
        .welcome-eyebrow { display: flex; align-items: center; gap: 9px; margin-bottom: 15px; color: #6478c9; font-size: .76rem; font-weight: 850; letter-spacing: 1.5px; text-transform: uppercase; }
        .welcome-eyebrow::before { content: ""; width: 25px; height: 2px; border-radius: 3px; background: #8c9cf0; }
        .welcome-content h2 { margin: 0 0 15px; font-size: clamp(2.25rem, 3.45vw, 3.3rem); font-weight: 850; line-height: 1.12; letter-spacing: -.052em; color: #121d37; }
        .welcome-content h2 em { color: var(--blue); font-style: normal; }
        .welcome-copy { max-width: 540px; margin: 0; color: var(--muted); font-size: .98rem; line-height: 1.85; }
        .welcome-actions { display: flex; flex-wrap: wrap; gap: 11px; margin-top: 27px; }
        .welcome-actions .button { min-height: 49px; padding: 13px 17px; }
        .login-prompt { margin: 18px 0 0; color: #8490a4; font-size: .81rem; }
        .login-prompt a { color: var(--blue); font-weight: 800; }
        .login-prompt a:hover { text-decoration: underline; }
        .mini-trust-row { display: flex; flex-wrap: wrap; gap: 17px; margin-top: 31px; padding-top: 22px; border-top: 1px solid var(--line); color: #69758c; font-size: .75rem; font-weight: 650; }
        .mini-trust-row span { display: inline-flex; align-items: center; gap: 7px; }
        .mini-trust-row svg { width: 17px; height: 17px; color: #688d85; }
        .right-footer { display: flex; justify-content: space-between; gap: 15px; color: #99a1b2; font-size: .72rem; }
        .right-footer a:hover { color: var(--blue); }

        .section { padding: 88px 24px; }
        .section-inner { width: min(1120px, 100%); margin: 0 auto; }
        .section-heading { width: min(660px, 100%); margin: 0 auto 42px; text-align: center; }
        .section-kicker { color: var(--blue); font-size: .73rem; font-weight: 850; letter-spacing: 1.65px; text-transform: uppercase; }
        .section-heading h2 { margin: 12px 0; color: #182544; font-size: clamp(1.9rem, 3.4vw, 2.65rem); line-height: 1.18; letter-spacing: -.045em; }
        .section-heading p { margin: 0; color: var(--muted); font-size: .96rem; line-height: 1.85; }
        .feature-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
        .feature-card { min-height: 225px; padding: 27px; border: 1px solid var(--line); border-radius: 18px; background: #fff; box-shadow: 0 8px 25px rgba(24,37,68,.025); transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
        .feature-card:hover { transform: translateY(-4px); border-color: #d8def5; box-shadow: 0 17px 34px rgba(24,37,68,.065); }
        .feature-icon { width: 47px; height: 47px; display: grid; place-items: center; margin-bottom: 21px; border-radius: 14px; }
        .feature-icon svg { width: 23px; height: 23px; }
        .feature-icon.blue { color: #5c72d4; background: #edf0ff; }
        .feature-icon.green { color: #3f8b72; background: #e4f7ef; }
        .feature-icon.gold { color: #ad7a23; background: #fff5d8; }
        .feature-card h3 { margin: 0 0 10px; color: #202e4b; font-size: 1.02rem; letter-spacing: -.2px; }
        .feature-card p { margin: 0; color: var(--muted); font-size: .88rem; line-height: 1.8; }
        .steps-section { background: #f7f8fc; border-top: 1px solid #edf0f6; border-bottom: 1px solid #edf0f6; }
        .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .step-card { position: relative; padding: 0 19px; text-align: center; }
        .step-number { display: grid; place-items: center; width: 48px; height: 48px; margin: 0 auto 17px; border-radius: 15px; color: #fff; background: var(--navy); font-size: .92rem; font-weight: 850; box-shadow: 0 8px 20px rgba(27,47,99,.14); }
        .step-card h3 { margin: 0 0 9px; font-size: 1rem; color: #202d49; }
        .step-card p { margin: 0; color: var(--muted); font-size: .88rem; line-height: 1.8; }
        .privacy-layout { display: grid; grid-template-columns: .9fr 1.1fr; align-items: center; gap: 60px; }
        .privacy-illustration { position: relative; display: grid; place-items: center; min-height: 300px; border: 1px solid #e8ecf8; border-radius: 25px; background: radial-gradient(circle at 50% 42%, #e9edff 0, #f6f7ff 52%, #fff 76%); overflow: hidden; }
        .privacy-illustration::before, .privacy-illustration::after { content: ""; position: absolute; border: 1px solid #dce3fb; border-radius: 50%; }
        .privacy-illustration::before { width: 230px; height: 230px; }
        .privacy-illustration::after { width: 290px; height: 290px; }
        .privacy-shield { z-index: 1; display: grid; place-items: center; width: 115px; height: 125px; color: #fff; background: linear-gradient(145deg, #667fe3, #344d9d); border-radius: 35px 35px 42px 42px; box-shadow: 0 22px 43px rgba(55,78,165,.25); transform: rotate(-3deg); }
        .privacy-shield svg { width: 54px; height: 54px; }
        .privacy-copy h2 { margin: 10px 0 15px; font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.18; letter-spacing: -.04em; }
        .privacy-copy p { margin: 0 0 16px; color: var(--muted); font-size: .93rem; line-height: 1.85; }
        .privacy-link { display: inline-flex; align-items: center; gap: 9px; color: var(--blue); font-weight: 800; font-size: .87rem; }
        .privacy-link:hover { text-decoration: underline; }
        .faq-section { background: #fff; }
        .faq-list { width: min(800px, 100%); margin: 0 auto; display: grid; gap: 12px; }
        .faq-item { padding: 19px 21px; border: 1px solid var(--line); border-radius: 14px; background: #fff; }
        .faq-item summary { position: relative; padding-right: 25px; list-style: none; cursor: pointer; color: #202d49; font-size: .93rem; font-weight: 800; }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-item summary::after { content: "+"; position: absolute; top: -4px; right: 0; color: var(--blue); font-size: 1.35rem; font-weight: 500; }
        .faq-item[open] summary::after { content: "−"; }
        .faq-item p { margin: 12px 0 0; color: var(--muted); font-size: .88rem; line-height: 1.8; }
        .cta-section { padding: 0 24px 86px; }
        .cta-panel { position: relative; display: flex; align-items: center; justify-content: space-between; gap: 35px; width: min(1120px, 100%); margin: 0 auto; padding: 39px 43px; overflow: hidden; border-radius: 22px; color: #fff; background: linear-gradient(112deg, #1b2f63, #2b4689); }
        .cta-panel::after { content: ""; position: absolute; width: 280px; height: 280px; border: 1px solid rgba(255,255,255,.12); border-radius: 50%; right: 140px; top: -200px; box-shadow: 0 0 0 35px rgba(255,255,255,.025), 0 0 0 72px rgba(255,255,255,.02); pointer-events: none; }
        .cta-panel > div { position: relative; z-index: 1; }
        .cta-panel h2 { margin: 0 0 9px; font-size: clamp(1.6rem, 3vw, 2.15rem); line-height: 1.22; letter-spacing: -.035em; }
        .cta-panel p { max-width: 650px; margin: 0; color: #d3dcf5; font-size: .91rem; line-height: 1.8; }
        .button-gold { position: relative; z-index: 1; flex: 0 0 auto; color: var(--navy); background: var(--gold); }
        .button-gold:hover { background: #ffe083; }
        .site-footer { padding: 25px 24px; border-top: 1px solid var(--line); background: #fff; }
        .footer-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; width: min(1120px, 100%); margin: 0 auto; color: #858fa3; font-size: .77rem; }
        .footer-brand { display: inline-flex; align-items: center; gap: 9px; color: var(--navy); font-weight: 850; }
        .footer-brand .brand-symbol { width: 31px; height: 31px; border-radius: 10px; color: #fff; background: var(--navy); box-shadow: none; }
        .footer-brand .brand-symbol svg { width: 17px; height: 17px; }

        @media (max-width: 1000px) {
            .split-hero { grid-template-columns: minmax(300px, .85fr) minmax(0, 1.15fr); }
            .brand-panel { padding: 35px clamp(25px, 4vw, 45px); }
            .panel-main h1 { font-size: clamp(2.65rem, 5vw, 3.55rem); }
            .welcome-panel { padding: 28px 34px 24px; }
            .top-nav { gap: 14px; }
            .top-nav .nav-anchor { display: none; }
            .privacy-layout { gap: 35px; }
        }
        @media (max-width: 760px) {
            .split-hero { min-height: auto; display: flex; flex-direction: column; }
            .brand-panel { min-height: auto; padding: 26px 24px 28px; }
            .brand-symbol { width: 42px; height: 42px; border-radius: 13px; }
            .panel-main { padding: 59px 0 49px; }
            .panel-main h1 { max-width: 490px; margin-top: 21px; font-size: clamp(2.7rem, 10vw, 4rem); }
            .panel-description { font-size: .95rem; }
            .panel-points { gap: 11px; margin-top: 25px; }
            .panel-bottom { align-items: flex-start; }
            .panel-bottom .bottom-tag { display: none; }
            .welcome-panel { padding: 18px 24px 22px; }
            .top-nav { justify-content: space-between; min-height: 48px; }
            .top-nav .nav-anchor { display: inline; }
            .welcome-content { padding: 42px 0 38px; margin: 0 auto; }
            .welcome-content h2 { font-size: clamp(2.35rem, 8.6vw, 3.2rem); }
            .welcome-copy { font-size: .93rem; }
            .welcome-actions { flex-direction: column; align-items: stretch; }
            .welcome-actions .button { width: 100%; }
            .mini-trust-row { gap: 12px 17px; }
            .right-footer { flex-wrap: wrap; }
            .section { padding: 64px 20px; }
            .section-heading { margin-bottom: 29px; }
            .feature-grid, .steps-grid { grid-template-columns: 1fr; gap: 14px; }
            .feature-card { min-height: 0; padding: 23px; }
            .step-card { padding: 0 8px 15px; }
            .privacy-layout { grid-template-columns: 1fr; gap: 29px; }
            .privacy-illustration { min-height: 230px; }
            .privacy-shield { width: 95px; height: 105px; border-radius: 29px 29px 35px 35px; }
            .cta-section { padding: 0 20px 62px; }
            .cta-panel { align-items: flex-start; flex-direction: column; gap: 24px; padding: 30px 25px; }
            .button-gold { width: 100%; }
            .footer-inner { align-items: flex-start; flex-direction: column; gap: 11px; }
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after { transition-duration: .01ms !important; animation-duration: .01ms !important; }
        }
    </style>
</head>
<body>
<div class="page-shell">
    <main>
        <section class="split-hero" aria-label="Welcome to SafeSpace">
            <aside class="brand-panel">
                <a class="brand" href="{{ url('/') }}" aria-label="SafeSpace home">
                    <span class="brand-symbol" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s-7.2-4.1-7.2-10V5.5L12 3l7.2 2.5V11c0 5.9-7.2 10-7.2 10Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8.1 12.2h2l1.2-2.3 1.5 4 1.1-1.8h2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <span class="brand-word">Safe<span>Space</span></span>
                </a>

                <div class="panel-main">
                    <div class="panel-kicker"><span class="live-dot" aria-hidden="true"></span> Student support starts here</div>
                    <h1>Every student deserves to feel <span>safe.</span></h1>
                    <p class="panel-description">A school community grows stronger when people can speak up, be heard, and find support. SafeSpace helps make that first step a little easier.</p>
                    <ul class="panel-points">
                        <li><span class="point-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="m5 12 4.2 4.2L19 6.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span> Share a concern in your own words</li>
                        <li><span class="point-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M4 5.5h16v11H9l-5 3v-14Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8 9h8M8 12.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span> Find a guided way to ask for support</li>
                        <li><span class="point-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span> Let authorized school staff review your concern</li>
                    </ul>
                </div>

                <div class="panel-bottom">
                    <div><strong>Made for student well-being</strong>A kinder school starts with listening.</div>
                    <div class="bottom-tag"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Care first.<br>One step at a time.</span></div>
                </div>
            </aside>

            <section class="welcome-panel" aria-labelledby="welcome-title">
                <nav class="top-nav" aria-label="Main navigation">
                    <a class="nav-anchor" href="#how-it-works">How it works</a>
                    <a class="nav-anchor" href="#privacy">Privacy</a>
                    <a class="button button-soft" href="{{ route('login') }}">Log in</a>
                </nav>

                <div class="welcome-content">
                    <div class="welcome-eyebrow">Welcome to SafeSpace</div>
                    <h2 id="welcome-title">Your voice matters.<br><em>We're here to listen.</em></h2>
                    <p class="welcome-copy">If something at school is bothering you, you don't need to figure everything out alone. SafeSpace gives you a clear starting point to report a concern and seek support.</p>
                    <div class="welcome-actions">
                        <a class="button button-navy" href="{{ route('login') }}">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M10 17 15 12 10 7M15 12H3M14 3h4a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3h-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Sign in to SafeSpace
                        </a>
                        <a class="button button-soft" href="{{ route('register') }}">Create a student account <span aria-hidden="true">→</span></a>
                    </div>
                    <p class="login-prompt">Already registered? <a href="{{ route('login') }}">Sign in to your account</a></p>

                    <div class="mini-trust-row" aria-label="SafeSpace principles">
                        <span><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>Privacy-aware reporting</span>
                        <span><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 5.5h16v11H9l-5 3v-14Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8 9h8M8 12.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>Guided support</span>
                    </div>
                </div>

                <div class="right-footer">
                    <span>© {{ date('Y') }} SafeSpace</span>
                    <a href="{{ route('privacy') }}">Privacy notice</a>
                    <a href="#support">Get support</a>
                </div>
            </section>
        </section>

        <section class="section" id="about">
            <div class="section-inner">
                <div class="section-heading">
                    <span class="section-kicker">A space for students</span>
                    <h2>A simpler first step toward support.</h2>
                    <p>It can be hard to talk about bullying or a difficult school experience. SafeSpace is designed to make sharing a concern feel more approachable.</p>
                </div>
                <div class="feature-grid">
                    <article class="feature-card">
                        <div class="feature-icon blue"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 12h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
                        <h3>Your voice matters</h3>
                        <p>Describe what happened in your own words. You can ask for help even when you're unsure how to label the situation.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon green"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 4.75h14A1.25 1.25 0 0 1 20.25 6v10A1.25 1.25 0 0 1 19 17.25h-8L5 20V5.5c0-.41.34-.75.75-.75Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8.5 9h7M8.5 12.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
                        <h3>Guided incident reporting</h3>
                        <p>Clear prompts help you organize details about what happened so the concern can be reviewed more easily.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon gold"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 18.5V20M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM16 8h5M18.5 5.5v5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                        <h3>Human review and support</h3>
                        <p>Reports can be reviewed by authorized school personnel who assess the situation and determine appropriate next steps.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section steps-section" id="how-it-works">
            <div class="section-inner">
                <div class="section-heading">
                    <span class="section-kicker">One step at a time</span>
                    <h2>How SafeSpace works</h2>
                    <p>You can take the process at your own pace. Here is the general flow from sharing a concern to follow-up.</p>
                </div>
                <div class="steps-grid">
                    <article class="step-card"><div class="step-number">01</div><h3>Sign in and share</h3><p>Use your student account to complete the incident report and share the details you feel comfortable providing.</p></article>
                    <article class="step-card"><div class="step-number">02</div><h3>Your report is reviewed</h3><p>AI assistance may help with preliminary risk prioritization, but it does not decide guilt or disciplinary action.</p></article>
                    <article class="step-card"><div class="step-number">03</div><h3>Receive appropriate support</h3><p>Authorized school personnel review the information and determine suitable follow-up based on the circumstances.</p></article>
                </div>
            </div>
        </section>

        <section class="section" id="privacy">
            <div class="section-inner privacy-layout">
                <div class="privacy-illustration" aria-hidden="true">
                    <div class="privacy-shield"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                </div>
                <div class="privacy-copy">
                    <span class="section-kicker">Privacy deserves care</span>
                    <h2>Your information should be handled responsibly.</h2>
                    <p>SafeSpace is built around careful handling of student concerns. Personal information should only be accessed by personnel authorized to handle reports, according to the school's procedures.</p>
                    <p>Before creating an account or submitting information, read the full privacy notice so you understand how information is collected and used.</p>
                    <a class="privacy-link" href="{{ route('privacy') }}">Read the privacy notice <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </section>

        <section class="section faq-section" id="support">
            <div class="section-inner">
                <div class="section-heading">
                    <span class="section-kicker">A little reassurance</span>
                    <h2>Questions you might have</h2>
                    <p>If you're unsure about taking the first step, these answers may help.</p>
                </div>
                <div class="faq-list">
                    <details class="faq-item"><summary>What if I'm not sure whether it's bullying?</summary><p>You can still raise a concern. You do not need to decide what to call the situation before asking an authorized school staff member to review it.</p></details>
                    <details class="faq-item"><summary>Does the AI decide whether someone is guilty?</summary><p>No. AI assistance is intended only for preliminary risk prioritization. A risk label is not a finding of guilt and should not replace human review.</p></details>
                    <details class="faq-item"><summary>Where can I read how my information is handled?</summary><p>Open the SafeSpace privacy notice before registering or submitting a report to learn more about the intended handling of personal information.</p></details>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <div class="cta-panel">
                <div>
                    <h2>You don't have to handle a difficult situation alone.</h2>
                    <p>When you're ready, sign in to SafeSpace to share a concern and take the next step toward support.</p>
                </div>
                <a class="button button-gold" href="{{ route('login') }}">Go to SafeSpace <span aria-hidden="true">→</span></a>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="footer-inner">
            <a class="footer-brand" href="{{ url('/') }}">
                <span class="brand-symbol" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 21s-7.2-4.1-7.2-10V5.5L12 3l7.2 2.5V11c0 5.9-7.2 10-7.2 10Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg></span>
                SafeSpace
            </a>
            <span>A kinder school starts with listening.</span>
            <span>© {{ date('Y') }} SafeSpace · <a href="{{ route('privacy') }}">Privacy notice</a></span>
        </div>
    </footer>
</div>
</body>
</html>
