<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class LoginCustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('customer')->check()) {
            $user = Auth::guard('customer')->user();
            //Xét quyền
            if ($user->roles == 2) {
                return $next($request);
            } else {
                return redirect('frontend.login');
            }
        }
        return $next($request);
    }
}
