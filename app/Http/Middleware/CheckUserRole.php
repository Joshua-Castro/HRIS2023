<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        $userRole = auth()->user()->role;

        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        return response()
        ->view('404-error-page', ['message' => 'You are not allowed to access this page. Please contact your HR'], 403);
    }
}
