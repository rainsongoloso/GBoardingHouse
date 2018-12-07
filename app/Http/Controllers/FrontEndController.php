<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use App\Reservation;
use Mail;
use App\Mail\SendMail;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Hash; 
use Illuminate\Support\Facades\Redirect;
use Auth;
class FrontEndController extends Controller
{
	public function onlineReservation()
	{
        return view('frontend.layouts.reservation');
    }

    public function displayBedSpacerRooms()
    {
        $bsRooms = Room::where('status','Available')->orWhere('status', 'Occupied')->where('type','Bed Spacer')->get();

    	return view('frontend.layouts.reservation_bedspacer',compact('bsRooms'));
    }

    public function displayPrivateRooms()
    {
    	$pRooms = Room::where('status','Available')->where('type','Private')->get();

    	return view('frontend.layouts.reservation_private',compact('pRooms'));
    }

    public function reservationForm($id,$changeFormat,$changeFormat2)
    {
            if(Auth::check())
            {
                $getUserId = Auth::user()->id;

                $room = Room::find($id);
                $holdStarDate = $changeFormat;
                $holdCheckOut = $changeFormat2;

                $formatThis = \Carbon\Carbon::parse($holdStarDate);
                $checkIn = $formatThis->toDateString();
                $formatThis2 = \Carbon\Carbon::parse($holdCheckOut);
                $checkOut = $formatThis2->toDateString();

                $reservation = new Reservation();  
                $reservation->user_id = $getUserId;
                $reservation->room_id = $id;
                $reservation->check_in = $checkIn;
                $reservation->check_out = $checkOut;
                $reservation->save();

                Session::flash('note','Visit the boarding house to pay your reservation. If you cant pay after 1 week of your reservation date your reservation will be canceled');

                return redirect('/client');
            }
            
            // return view('frontend.layouts.reservation_form',compact('room','holdStarDate','holdCheckOut'));
    }

    public function reserve(Request $request, $id)
    {
        if(Auth::check())
        {
            if(Auth::user()->role == 'Client')
            {

                    $getAuthId = auth()->user()->id;

                    $getTime = \Carbon\Carbon::now();
                    $holdHour = $getTime->hour;
                    $holdMinutes = $getTime->minute;

                    $room = Room::find($id);

                    $validatedData = $request->validate([
                    'firstname'     => 'required|max:25',
                    'lastname'      => 'required|max:25',
                    'contact_no'    => 'required|max:11|regex:/(09)[0-9]{9}/',
                    'dob'           => 'required|date',
                    'street_ad'     => 'required|max:50',
                    'city'          => 'required|max:25',
                    'province'      => 'required|max:25',
                    'start_date'    => 'required|date',
                    'check_out'     => 'required|date',
                    ]);

                    $getCheckin = $request->start_date;
                    $getCheckOut = $request->check_out;

                    $tobeFormat = \Carbon\Carbon::parse($getCheckin);
                    $tobeFormat2 = \Carbon\Carbon::parse($getCheckOut);

                    $formatThis = $tobeFormat->toDateString();
                    $formatThis2= $tobeFormat2->toDateString();

                    
                    $user = User::findOrFail($getAuthId);

                    if($user)
                    {   
                        $user->firstname = $request->get('firstname');
                        $user->lastname = $request->get('lastname');
                        $user->contact_no = $request->get('contact_no');
                        $user->dob = $request->get('dob');
                        $user->street_ad = $request->get('street_ad');
                        $user->city = $request->get('city');
                        $user->province = $request->get('province');
                        $user->dob = $request->get('firstname');
                        $user->save();
                    }

                    $reservation = new Reservation;
                    $reservation->check_in = $formatThis;
                    $reservation->check_out = $formatThis2;
                    $reservation->user_id = $getAuthId;
                    $reservation->room_id = $room->id;
                    $reservation->save();

                    return redirect('/online/reservation');
                
            }
        }
        else
        {
            return redirect(route('register'));
        }
        
    }

    public function confirm($token)
    {
        if( ! $token)
        {
            return Redirect::route('login')->with('warning','Cant verify this account');
        }

        $user = User::where('email_token',$token)->first();

        if ( ! $user)
        {
            return Redirect::route('login')->with('warning','Cant verify this account');
        }

        $user->verified = 1;
        $user->email_token = null;
        $user->save();

        Session::flash('message','You have successfully verified your account.');

        return redirect('/client');
    }

    public function searchReservation(Request $request)
    {     
        if(Auth::guest())
        {
            Session::flash('message','Please login or sign up, to reserve a room ');

            return redirect(route('register'));     
        }
        else
        {
        $validatedData = $request->validate([
        'start_date' => 'required',
        'check_out' => 'required',
        ]);

        $start_date = $request->start_date;
        $check_out = $request->check_out;

        $toString = \Carbon\Carbon::parse($start_date);
        $format = $toString->toDateString();
        $toString2 = \Carbon\Carbon::parse($check_out);
        $format2 = $toString2->toDateString();

        $formatTo = \Carbon\Carbon::parse($start_date);
        $changeFormat = $formatTo->formatLocalized('%A, %B %d %Y');

        $formatTo2 = \Carbon\Carbon::parse($check_out);
        $changeFormat2 = $formatTo2->formatLocalized('%A, %B %d %Y');
                
        $searchRoom = \DB::table('rooms')
        ->where('status','<>','Full')
            ->whereNotIn('id', function($query) use ($format,$format2)
             {
                $query->select('room_id')
                    ->from(with(new Reservation)->getTable())
                    ->where(function($query) use ($format,$format2)
                    {
                        $query
                        ->where('check_in','<=',$format2)
                        ->where('check_out','>=',$format)
                        ->where('status','=','Active')
                        ;
                    });
             })
            ->orderBy('type')
            ->get();

        return view('frontend.layouts.reservation_search',compact('searchRoom','changeFormat','changeFormat2'));
        }
        
    }

    public function displayAllRooms()
    {
        $rooms = Room::orderBy('type')->get();

        return view('frontend.layouts.rooms',compact('rooms'));
    }

}
