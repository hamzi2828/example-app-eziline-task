<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// app/Http/Middleware/ManagerMiddleware.php
class ManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth()->user()->user_type == 'manager') {

            return $next($request);
            
        }

        abort(403, 'Unauthorized Action . .');


    }
}

