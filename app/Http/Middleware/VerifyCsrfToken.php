<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
    	'admin/photo_manage/picture/',
    	'/blog/register',
    	'/blog/dologin',
        '/code_captcha/check_code',
        'admin/article_manage/upload/article',
        '/test',
    ];
}
