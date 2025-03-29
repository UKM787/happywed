<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
class RedirectIfAuthenticated
{
    use HasRoles;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        // Skip redirection for invitation-related routes
        $routeName = $request->route()->getName();
        if (strpos($routeName, 'invitation') !== false || 
            strpos($routeName, 'hostinvitations') !== false || 
            strpos($routeName, 'hostceramony') !== false) {
            return $next($request);
        }

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch ($guard) {
                    case 'host':
                        foreach (auth()->guard('host')->user()->getRoleNames() as $role) {
                            switch($role) {
                                case 'emanager':
                                    return redirect(route('emanagerDashboard', auth()->guard('host')->user()));
                                case 'member':
                                    return redirect(route('memberDashboard.index', auth()->guard('host')->user()));
                                case 'groom':
                                    return redirect(route('groomDashboard.index', auth()->guard('host')->user()));
                                case 'bride':
                                    return redirect(route('brideDashboard.index', auth()->guard('host')->user()));
                                default:
                                    return redirect(route('hostwelcome'));
                            }
                        }
                        break;
                    case 'vendor':
                        return redirect(route('vendorwelcome'));
                    case 'admin':
                        return redirect(route('adminwelcome'));
                    default:
                        return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}
