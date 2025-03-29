<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckHostSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip subscription check for subscription-related routes
        $routeName = $request->route()->getName();
        $excludedRoutes = [
            'subscribePage',
            'subscribeCreateOrder',
            'subscribeVerifyPayment',
            'subscribeReccuringPage',
            'subscribeCreateSubscribe',
            'cancelSubscription',
            'subscribeWebhook'
        ];

        if (in_array($routeName, $excludedRoutes)) {
            return $next($request);
        }

        $user = Auth::guard(Auth::getDefaultDriver())->user();
        
        if (!$user) {
            return $next($request);
        }

        $subCreated = $user->activeSubscription();
        
        if ($subCreated) {
            return $next($request);
        }

        return redirect()->route('subscribePage')->with([
            'status' => 'Success',
            'message' => 'Kindly choose subscription first!'
        ]);
    }
}
