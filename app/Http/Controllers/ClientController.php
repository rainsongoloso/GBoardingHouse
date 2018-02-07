<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Reservation;
use App\Room;
use Session;
use App\Occupant;
use App\Financial;
class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	if(Auth::check())
		{
			if(Auth::user()->role == 'Client')
			{
				$getAuthId = auth()->user()->id;

                $userreserv = User::find($getAuthId)->reservation;

                if(count($userreserv)>0)
                {
                    return view('client.index',compact('userreserv'));
                }
                else
                {
                    return view('client.index',compact('userreserv'));
                }
			}
            else if(Auth::user()->role == 'Tenant')
            {
                $getAuthId = auth()->user()->id;

                $user = User::find($getAuthId);

                return view('tenant.dashboard',compact('user'));  
            }	  
		}
    }
    
    public function reservationEdit($id)
    {
    	$reservation = Reservation::find($id);

    	$rooms = Room::where('status','Available')->get();

        $getToday = \Carbon\Carbon::now();

        $format = $getToday->toDateString();

    	return view('client.edit',compact('reservation','rooms','format'));
    }

    public function reseveEdit(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        $validatedData = $request->validate([
        'room_id'   => 'required',
        'start_date' => 'required|date', 
        ]);

    	$reservation->start_date = $request->start_date;
    	$reservation->room_id  = $request->room_id;
    	$reservation->save();

        Session::flash('message','Reservation successfully updated!');

        return redirect('/client');

    }
}
