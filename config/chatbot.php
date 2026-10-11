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
    'topics' => [
        [
            'name' => 'how_to_report',
            'keywords' => ['paano mag-report', 'paano magreport', 'how to report', 'mag report', 'report', 'i-report'],
            'answer' => "To report: go to Student Home, click \"Report an Incident\", fill in what happened, when and where, then submit. "
                . "You will get a reference number so you can check the status under My Reports.",
        ],
        [
            'name' => 'what_next',
            'keywords' => ['ano mangyayari', 'what happens', 'after i report', 'susunod', 'next step', 'status'],
            'answer' => "After you report, the guidance counselor reviews it. They may message you inside your report. "
                . "You can see the status under My Reports: Received, Being Reviewed, In Progress, or Resolved.",
        ],
        [
            'name' => 'what_is_bullying',
            'keywords' => ['ano ang bullying', 'what is bullying', 'is this bullying', 'bullying ba', 'counts as bullying'],
            'answer' => "Bullying is repeated hurtful behavior: name-calling, hitting or pushing, threats, leaving someone out on purpose, "
                . "spreading rumors, or harassing someone online. If it hurts you and you are unsure, you can still report it.",
        ],
        [
            'name' => 'confidentiality',
            'keywords' => ['confidential', 'secret', 'sino makakakita', 'who can see', 'private', 'sino makaka-alam', 'malalaman'],
            'answer' => "If you choose Confidential, only the guidance counselor can see your name. "
                . "The students named in your report will not be told who reported.",
        ],
        [
            'name' => 'who_to_talk',
            'keywords' => ['sino kausapin', 'who can i talk', 'counselor', 'guidance', 'help', 'tulong', 'kausapin'],
            'answer' => "You can talk to the guidance counselor. After you submit a report, you can also message them inside the report page.",
        ],
        [
            'name' => 'greeting',
            'keywords' => ['hi', 'hello', 'kumusta', 'good morning', 'good afternoon'],
            'answer' => "Hello! I can help with how to report, what happens next, what counts as bullying, and who can see your report.",
        ],
    ],
];