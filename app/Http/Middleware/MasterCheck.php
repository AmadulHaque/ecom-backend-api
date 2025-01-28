<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MasterCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('Authorization') == null) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $request->bearerToken();
        $expectedToken = config('services.shop.token');

        if (! $token || $token !== $expectedToken) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        return $next($request);
    }
}
