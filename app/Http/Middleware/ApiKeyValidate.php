<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has("api_key")) {
        return response()->json([
            'status' => 401,
            'message' => 'Acceso no autorizado',
        ], 401);
        }

        if ($request->has("api_key")) {
        $api_key = "fnPqT5xQEi5Vcb9wKwbCf65c3BjVGyBB";
        if ($request->input("api_key") != $api_key) {
            return response()->json([
            'status' => 401,
            'message' => 'Acceso no autorizado',
            ], 401);
        }
        }

        return $next($request);
    }
}
