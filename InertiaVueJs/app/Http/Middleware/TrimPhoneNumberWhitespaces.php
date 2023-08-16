<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrimPhoneNumberWhitespaces
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->method(), ['POST', 'PUT'])) {
            foreach ($request->all() as $key => $value) {
                if (str($key)->contains('phone')) {
                    $request->merge([$key => str($value)->replace(' ', '')->toString()]);
                }
            }
        }

        return $next($request);
    }
}
