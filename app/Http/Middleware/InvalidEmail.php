<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class InvalidEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() && !Str::contains(Auth::user()->email, env('APP_EMAIL', '@tabel.dev'))) {
            Auth::logout();
            return redirect()
                    ->route('filament.admin.auth.login')
                    ->with(
                        'alert',
                        __('invalid_email')
                    );
        }

        return $next($request);
        // abort(403, 'You need to verify your email address and waiting for admin verification to access this page.');
    }
}
