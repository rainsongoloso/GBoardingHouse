<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Session;
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

    protected $redirectTo = '/home';

    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->role == 'Admin')
        {
            return redirect('/admin'); 
        }
        else if($user->role == 'Client')
        {
            
            if(!$user->verified == 1)
            {
                auth()->logout();
                return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
            }
            else if($user->status == 'Inactive')
            {
                auth()->logout();
                return back()->with('warning', 'This account is inactive, contact the admin to Activate your account');
            }
            else
            {
                if(count($user->reservation) > 0)
                {
                    return redirect('/client');
                }
                else
                {
                    return redirect('/');  
                }
            }
             
        }
        else
        {   
            return redirect('/client');
        }
    }

    public function username()
    {
        return 'username';
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        Session::flash('message','User successfully logout');

        return redirect('/login');
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt($this->credentials($request), $request->filled('remember')
        );
    }
}
