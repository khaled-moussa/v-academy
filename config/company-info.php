<?php

return [

    /*
    |-------------------------------
    | Company Basic Info
    |-------------------------------
    */

    'name' => env('COMPANY_NAME', 'Varaibles Academy'),

    'tax_number' => env('COMPANY_TAX_NUMBER', null),

    'commercial_number' => env('COMPANY_COMMERCIAL_NUMBER', null),

    /*
    |-------------------------------
    | Contact Info
    |-------------------------------
    */

    'phones' => [],

    'address' => env('COMPANY_ADDRESS', ''),

    'support_email' => env('COMPANY_SUPPORT_EMAIL', null),
];
