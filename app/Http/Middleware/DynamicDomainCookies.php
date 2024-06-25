<?php

namespace App\Http\Middleware;

use Closure;

class DynamicDomainCookies
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();

        if (str_contains($host, 'localhost')) {
            config(['session.domain' => null]);
        } else {
            config(['session.domain' => '.ecovoit.tech']);
        }

        return $next($request);
    }
}

