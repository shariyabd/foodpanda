<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SSO Auth Server Configuration
    |--------------------------------------------------------------------------
    */

    'host' => env('SSO_HOST', 'http://127.0.0.1:8000'),

    'client_id' => env('SSO_CLIENT_ID'),

    'client_secret' => env('SSO_CLIENT_SECRET'),

    'callback_url' => env('SSO_CALLBACK_URL', 'http://127.0.0.1:8002/auth/callback'),

    /*
    |--------------------------------------------------------------------------
    | SSO Endpoints
    |--------------------------------------------------------------------------
    */

    'authorize_url' => env('SSO_HOST', 'http://127.0.0.1:8000') . '/oauth/authorize',

    'token_url' => env('SSO_HOST', 'http://127.0.0.1:8000') . '/oauth/token',

    'user_url' => env('SSO_HOST', 'http://127.0.0.1:8000') . '/api/user',

    'logout_url' => env('SSO_HOST', 'http://127.0.0.1:8000') . '/logout',

    /*
    |--------------------------------------------------------------------------
    | SSO Scopes
    |--------------------------------------------------------------------------
    */

    'scopes' => env('SSO_SCOPES', 'user-read user-email'),

];