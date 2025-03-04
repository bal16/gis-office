<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifiedAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() && Auth::user()->email_verified_at && !Auth::user()->accepted_at) {
            Auth::logout();
            return redirect()
                    ->route('filament.admin.auth.login')
                    ->with(
                        'alert',
                        'You need to waiting for admin verification.'
                    );
        }

        return $next($request);
        // abort(403, 'You need to verify your email address and waiting for admin verification to access this page.');
    }
}
