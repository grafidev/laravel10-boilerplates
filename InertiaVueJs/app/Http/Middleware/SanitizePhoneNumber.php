<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizePhoneNumber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'])) {
            foreach ($request->keys() as $key) {
                if (
                    preg_match('/phone/', $key) && \is_valid_phone_number($request->get($key))
                ) {
                    dd(\format_phone_number($request->get($key)));
                    $request->merge([
                        $key => \format_phone_number($request->get($key)),
                    ]);
                }
            }
        }

        return $next($request);
    }
}
