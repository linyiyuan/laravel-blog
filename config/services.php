<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID',''),
        'client_secret' => env('GITHUB_CLIENT_SECRET',''),
        'redirect' => env('GITHUB_REDIRECT',''),
    ],

    'weibo' => [
        'client_id' => env('WEIBO_KEY',''),
        'client_secret' => env('WEIBO_SECRET',''),
        'redirect' => env('WEIBO_REDIRECT_URI' ,''),
    ],

    'qq' => [
        'client_id' => env('QQ_APP_ID', ''),
        'client_secret' => env('QQ_APP_KEY', ''),
        'redirect' => env('QQ_REDIRECT', ''),
    ],

];
