<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddRoutePrefix
{
    public function handle($request, Closure $next)
    {
        // Define o prefixo desejado
        $request->server->set('REQUEST_URI', '/order-tracking' . $request->getRequestUri());
        
        return $next($request);
    }
}