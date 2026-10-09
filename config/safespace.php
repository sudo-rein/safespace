<?php

return [
    'dpo_name' => env('DPO_NAME', 'Data Protection Officer (to be assigned)'),
    'dpo_contact' => env('DPO_CONTACT', 'dpo@ecis.edu.ph'),
    'retention_years' => (int) env('RETENTION_YEARS', 5),
];