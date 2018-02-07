<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use App\Reservation;
use Mail;
use App\Mail\SendMail;
use Session;
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

    public function reservationForm($id)
    {
        $room = Room::find($id);

        return view('frontend.layouts.reservation_form',compact('room'));
    }

    public function reserve(Request $request, $id)
    {
        $room = Room::find($id);

        // $reservation = new Reservation;
        // $reservation->start_date = $request->start_date;
        // $reservation->user_id = $authId;
        // $reservation->room_id = $room->id;
        // $reservation->save(); 
    
        $room = Room::find($id);

        $validatedData = $request->validate([
        'firstname'     => 'required|max:25',
        'lastname'      => 'required|max:25',
        'email'         => 'required|unique:users',
        'contact_no'    => 'required|max:11|regex:/(09)[0-9]{9}/',
        'dob'           => 'required|date',
        'street_ad'     => 'required|max:50',
        'city'          => 'required|max:25',
        'province'      => 'required|max:25',
        'start_date'    => 'required|date',
        'username'      => 'required|unique:users',
        'password'      => 'required',
        ]);
        
        $user = new User;   
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->contact_no = $request->contact_no;
        $user->dob = $request->dob;
        $user->street_ad = $request->street_ad;
        $user->city = $request->city;
        $user->province = $request->province;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        $reservation = new Reservation;
        $reservation->start_date = $request->start_date;
        $reservation->user_id = $user->id;
        $reservation->room_id = $room->id;
        $reservation->save();

         

        Session::flash('message','Reservation successfully created!. You may now use your account to manage your reservation.');

        //return redirect('/login');
        
        return redirect('/online/reservation');
    }

    public function mail()
    {
        Mail::send(new SendMail);

        // ['text'=>'mail'],['name','Rainson'],function($message){
        //     $message->to('rainsongame@gmail.com','HELLO BOY GAMER')->subject('Test Email');
        //     $message->from('lasaweroll@gmail.com','Rainson');
        // }
    }
}
