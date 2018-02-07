<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminLoginController extends Controller
{
    //
	public function __construct()
	{
		$this->middleware('guest')->except('destroy');
	}

    public function display()
    {
    	return view('adminlogin.login');
    }

    public function logined(Request $request)
    {	
        
        if(!Auth::attempt(request(['username','password'])))
        {
        
        }
            return redirect('/admin');   
	}

    public function destroy()
    {
    	Auth::logout();
    	return redirect('login');
    }
}
