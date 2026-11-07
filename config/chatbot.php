<?php

return [

    // ====== HOTLINES: Galing dapat sa ======
    'hotlines' => [
        ['name' => 'School Guidance Office', 'contact' => '[PLACEHOLDER: office phone or room]'],
        ['name' => 'National crisis hotline', 'contact' => '[PLACEHOLDER: verified number]'],
        ['name' => 'Local barangay / emergency', 'contact' => '[PLACEHOLDER: verified number]'],
    ],

    'crisis_message' => "I'm really glad you told someone. You are not alone, and your safety matters most. "
        . "Please talk to the guidance counselor or a trusted adult right now. "
        . "If you are in danger, call emergency services.",

    'fallback' => "I'm not sure about that. You can ask me how to report, what happens next, "
        . "what counts as bullying, or who can see your report. You can also message the guidance counselor directly.",

    // Each topic: keywords (lowercase, matched as words/phrases) and the answer.
   'suggestions' => ['How do I report?', 'Where are my reports?', 'Who can see my name?', 'What is bullying?'],

'topics' => [
    [
        'name' => 'how_to_report',
        'keywords' => ['paano mag-report', 'paano magreport', 'how to report', 'mag report', 'magreport', 'report', 'i-report', 'gusto ko mag report'],
        'answer' => "To report: open the report form, choose Confidential or Named, tell us what happened, when and where, then submit. You will get a reference number.",
        'links' => [['label' => 'Open the report form', 'route' => 'student.report.create']],
    ],
    [
        'name' => 'my_reports',
        'keywords' => ['my reports', 'status', 'check my report', 'nasaan report ko', 'where are my reports', 'track', 'reference number', 'ano na nangyari'],
        'answer' => "You can see every report you sent and its status (Received, Being Reviewed, In Progress, Resolved) in My Reports. You can also export them as PDF or Excel there.",
        'links' => [['label' => 'Go to My Reports', 'route' => 'student.reports.index']],
    ],
    [
        'name' => 'what_next',
        'keywords' => ['ano mangyayari', 'what happens', 'after i report', 'susunod', 'next step', 'what next'],
        'answer' => "After you report, the guidance counselor reviews it and may message you inside your report. Open your report to read and reply.",
        'links' => [['label' => 'Go to My Reports', 'route' => 'student.reports.index']],
    ],
    [
        'name' => 'message_counselor',
        'keywords' => ['message counselor', 'chat with counselor', 'talk to counselor', 'kausapin counselor', 'send message', 'reply'],
        'answer' => "You can message the guidance counselor inside any report you submitted. Open the report and use the Messages box. Only you and the counselor can see it.",
        'links' => [['label' => 'Go to My Reports', 'route' => 'student.reports.index']],
    ],
    [
        'name' => 'what_is_bullying',
        'keywords' => ['ano ang bullying', 'what is bullying', 'is this bullying', 'bullying ba', 'counts as bullying', 'types of bullying'],
        'answer' => "Bullying is repeated hurtful behavior: name-calling, hitting or pushing, threats, leaving someone out on purpose, spreading rumors, or harassing someone online. If it hurts you and you are unsure, you can still report it.",
        'links' => [['label' => 'Report an incident', 'route' => 'student.report.create']],
    ],
    [
        'name' => 'confidentiality',
        'keywords' => ['confidential', 'secret', 'sino makakakita', 'who can see', 'private', 'sino makaka-alam', 'malalaman', 'my name', 'pangalan ko'],
        'answer' => "If you choose Confidential, only the guidance counselor can see your name. The students named in your report are never told who reported.",
        'links' => [['label' => 'Read the privacy notice', 'route' => 'privacy']],
    ],
    [
        'name' => 'evidence',
        'keywords' => ['evidence', 'screenshot', 'photo', 'picture', 'upload', 'attach', 'ebidensya'],
        'answer' => "You can attach up to 3 files (JPG, PNG, or PDF, 5 MB each) in the report form. Evidence is optional and stays private.",
        'links' => [['label' => 'Open the report form', 'route' => 'student.report.create']],
    ],
    [
        'name' => 'witness',
        'keywords' => ['witness', 'nakita ko', 'i saw', 'kaibigan ko', 'my friend', 'someone else'],
        'answer' => "You can report something that happened to someone else. In the form, add the person and choose Victim or Witness for each name.",
        'links' => [['label' => 'Open the report form', 'route' => 'student.report.create']],
    ],
    [
        'name' => 'privacy',
        'keywords' => ['privacy', 'data', 'personal information', 'data privacy', 'ra 10173'],
        'answer' => "SafeSpace follows the Data Privacy Act (RA 10173). Only the guidance counselor can see reports, and access is logged.",
        'links' => [['label' => 'Read the privacy notice', 'route' => 'privacy']],
    ],
    [
        'name' => 'who_to_talk',
        'keywords' => ['sino kausapin', 'who can i talk', 'counselor', 'guidance', 'help', 'tulong', 'kausapin', 'need someone'],
        'answer' => "You can talk to the guidance counselor. Submit a report, then message them inside it. If you need someone right now, visit the guidance office.",
        'links' => [['label' => 'Open the report form', 'route' => 'student.report.create']],
    ],
    [
        'name' => 'hotlines',
        'keywords' => ['hotline', 'emergency', 'call', 'phone number', 'contact number'],
        'answer' => "Here are the numbers you can call.",
        'show_hotlines' => true,
    ],
    [
        'name' => 'home',
        'keywords' => ['home', 'dashboard', 'main page', 'start'],
        'answer' => "Here is your home page.",
        'links' => [['label' => 'Student Home', 'route' => 'student.home']],
    ],
    [
        'name' => 'greeting',
        'keywords' => ['hi', 'hello', 'kumusta', 'good morning', 'good afternoon', 'hey'],
        'answer' => "Hello! I can help you report, check your reports, and answer questions about privacy and what happens next.",
    ],
    [
        'name' => 'thanks',
        'keywords' => ['thanks', 'thank you', 'salamat', 'ok thanks'],
        'answer' => "You're welcome. You're not alone, and you can come back any time.",
    ],
],
];