<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Mail;
use Session;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

       return redirect(route('login'));
        // $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
            'street_ad' => 'required|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'dob' => 'required|date',
            'contact_no' => 'required|regex:/(09)[0-9]{9}/|size:11',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'street_ad' => $data['street_ad'],
            'city' => $data['city'],
            'province' => $data['province'],
            'dob' => $data['dob'],
            'email' => $data['email'],
            'contact_no' => $data['contact_no'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'email_token' => Str::random(40),
        ]);

        $thisUser = User::findOrFail($user->id);
        $this->sendEmailTo($thisUser);

        Session::flash('message','Account Registered, please verify your account');
    }

    public function sendEmailTo($thisUser)
    {
        Mail::to($thisUser['email'])->send(new SendMail($thisUser));
    }

    public function sendEmailDone($email,$token)
    {
        $user = User::where(['email' => $email , 'email_token' => $token])->first();

        if($user)
        {
            $user = User::where(['email' => $email, 'email_token' => $token])->update(['verified' => '1' , 'email_token' => NULL]);
            Session::flash('message','Account Successfully verified');
            return redirect(route('login'));
        }
        else
        {
            return view('email.token_done');
        }

    }
}
