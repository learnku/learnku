<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed TLDs - Use with caution!
    |--------------------------------------------------------------------------
    |
    | This is to prevent mis-usage during production if debug mode is
    | unintentionally left active. The package will detect the site
    | URL and if the TLD isn't present in this array, it will not
    | activate. If your development TLD is different to .dev or
    | .local, simply add it to the arrow below.
    |
     */
    
    'allowed_tlds' => ['dev', 'local', 'test'],

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | Path to the application User model. This will be used to retrieve the users
    | displayed in the select dropdown. This must be an Eloquent Model instance.
    |
     */

    // 用户模型
    'user_model' => App\Models\User::class
    
];
