<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Cookie;

class GenerateAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if (Auth::check() && $request->is('login') && $request->isMethod('post')) {
            $user = Auth::user();
            $tokenResult = $user->createToken('auth_token');
            $plainTextToken = $tokenResult->plainTextToken;
            $cookie = Cookie::make('auth_token', $plainTextToken, 60 * 24 * 30, '/', null, false, false);
            $response->withCookie($cookie);
        }
        
        return $response;
    }
} 