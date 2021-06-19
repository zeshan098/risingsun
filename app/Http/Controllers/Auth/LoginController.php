<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $data['page_title'] = "Login Form";
        return view('admin.login')->with($data);
    }

    public function login(Request $request)
    {
        $credentials = array(
            "email" => $request->input('email'),
            "password" => $request->input('password')
        );
        //dd($credentials);
        if (Auth::attempt($credentials)) {
            
            if(Auth::user()->is_deleted == "1"){
                Auth::logout();
                return redirect()->back()->with('error', 'Incorrect User or Password!2');
            }else if(Auth::user()->is_active == "0"){
                Auth::logout();
                return redirect()->back()->with('error', 'Account inactive contact administrator!');
            }else if(Auth::user()->is_approved == "0"){
                Auth::logout();
                return redirect()->back()->with('error', 'Account inactive contact administrator!');
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
        else{
           
            return redirect()->back()->with('error', 'Incorrect User or Password!');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        
        return redirect()->intended('login');
    }
}
