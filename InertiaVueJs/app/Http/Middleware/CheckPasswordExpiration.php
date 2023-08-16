<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $user = $request->user();

        // if ($user && $user->password_updated_at) {
        //     $passwordAgeInDays = $user->password_updated_at->diffInDays(now());

        //     $maxPasswordAgeInDays = settings('password_validity_duration', 30);

        //     if ($passwordAgeInDays >= $maxPasswordAgeInDays) {
        //         return redirect()->route('profile.edit');
        //     }
        // }

        return $next($request);
    }
}
