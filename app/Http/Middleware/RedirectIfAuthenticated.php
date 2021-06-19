<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //dd(Auth::user()->role);
        if (Auth::guard($guard)->check()) {
//            return redirect('/home');
            if(Auth::user()->is_deleted == "1"){
                Auth::logout();
                return redirect()->intended('login')->with('error', 'Incorrect User or Password!');
            }else if(Auth::user()->is_active == "0"){
                Auth::logout();
                return redirect()->intended('login')->with('error', 'Account inactive contact administrator!');
            }else if(Auth::user()->is_approved == "0"){
                Auth::logout();
                return redirect()->intended('login')->with('error', 'Account inactive contact administrator!');
            }
            // Authentication passed...
            else if(Auth::user()->role == "admin"){
                return redirect()->intended('admin/show_donation');
            }
            else if(Auth::user()->role == "executive"){
                return redirect()->intended('executive/show_donation');
            }
            else if(Auth::user()->role == "finance"){
                return redirect()->intended('finance/incentive_report');
            }
            // else if(Auth::user()->role == "oil_filling"){
            //     return redirect()->intended('oil_filling/filing_detail');
            // }
            // else if(Auth::user()->role == "booking"){
            //     return redirect()->intended('booking/booking_list');
            // }
            // else if(Auth::user()->role == "uper"){
            //     return redirect()->intended('uper/monthly_report');
            // }
            // else if(Auth::user()->role == "lower"){
            //     return redirect()->intended('lower/booking_list');
            // }
            // else if(Auth::user()->role == "clerk1"){
            //     return redirect()->intended('clerk1/booking_list');
            // }
            else{
                Auth::logout();
                return redirect()->back()->with('error', 'Incorrect User or Password!');
            }
        }

        return $next($request);
    }
}
