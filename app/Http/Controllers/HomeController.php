<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Occupant;
use App\Financial;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     if(Auth::check())
    //     {
    //         if(Auth::user()->role == 'Tenant')
    //         {
    //             $getAuthId = auth()->user()->id;

    //             $user = User::find($getAuthId);

    //             return view('tenant.dashboard',compact('user'));
    //         } 
    //     }         
    // }

    
    public function financial()
    {
        $getAuthId = auth()->user()->id;

        $occupant = User::find($getAuthId)->occupant;

        if(count($occupant)>0)
        {
            $getOccuId = $occupant->id;

            $financials = Occupant::find($getOccuId)->financials;

            $financial1 = Occupant::find($getOccuId)->financials->sum('credit');

            $financial2 = Occupant::find($getOccuId)->financials->sum('debit');

            $balance = $financial1 - $financial2;

            $occupantA = Occupant::find($getOccuId)->amenities()->get();
            $occupantASum = Occupant::find($getOccuId)->amenities()->sum('rate');

            return view('tenant.financials',compact('occupant','financials','financial1','$financial2','balance','occupantA','occupantASum'));
        }
        else
        {
          return view('tenant.financials',compact('occupant'));
        }

    }

    public function account()
    {
      $getAuthId = auth()->user()->id;

       $user = User::find($getAuthId); 

       return view('tenant.account',compact('user'));
    }

    public function editAccount(Request $request)
    {
      $getAuthId = auth()->user()->id;

      $validatedData = $request->validate([
      'firstname'     => 'required|max:25',
      'lastname'      => 'required|max:25',
      'street_ad'     => 'required|max:50',
      'city'          => 'required|max:15',
      'province'      => 'required|max:15',
      'contact_no'    => 'required|regex:/(09)[0-9]{9}/|size:11',
      'dob'           => 'required|date',
      'email'         => 'required|email',
      'username'      => 'required',
      'password'      => 'nullable|confirmed',
      ]);

      $user = User::find($getAuthId);

      $user->firstname = $request->firstname;
      $user->lastname  = $request->lastname;
      $user->street_ad = $request->street_ad;
      $user->city      = $request->city;
      $user->province  = $request->province;
      $user->contact_no= $request->contact_no;
      $user->dob       = $request->dob;
      $user->email     = $request->email;
      $user->username  = $request->username;
      if($request->password != '')
      {
       $user->password  = bcrypt($request->password);
      } 

      if($user->save())
      {
        Session::flash('message','Account successfully updated!');
      }
      else
      {
        Session::flash('validate','an error occured when updating account');
      }

      return back();
    }

    public function reservation()
    { 
      $getId = Auth::user()->id;

      $uReservation = User::find($getId); 

      return view('tenant.reservation',compact('uReservation'));
    }


}
