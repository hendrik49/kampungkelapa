<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/getAllUser',
        '/getUserByEmail',
        '/create_data',
        '/update_data',
        '/delete_data',
        '/getRealisasi'        
    ];
}
