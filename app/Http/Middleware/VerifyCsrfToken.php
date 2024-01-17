<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */

     protected $except = [
        // Otros elementos excluidos...
        '/submit-form',
    ];
    
    protected $middlewareGroups = [
        'web' => [
            // Otros middlewares...
            \App\Http\Middleware\VerifyCsrfToken::class,
        ],
    
        // Otros grupos de middlewares...
    ];
    
}
