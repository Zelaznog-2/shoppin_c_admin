<?php

namespace App\Http\Middleware;

use App\Services\ResponseServices;
use Closure;
use Illuminate\Support\Env;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorization = $request->header('Authorization');
        $authorizationEnv = Env::get('VITE_TOKEN_URL');

        if ($authorization !== $authorizationEnv) {
            return ResponseServices::responseNotAllowed();
        }
        return $next($request);
    }
}
