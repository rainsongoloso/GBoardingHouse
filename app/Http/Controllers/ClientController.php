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

                $userOc = User::find($getAuthId)->occupant;

                if(count($userOc)>0)
                {
                    $occId = $userOc->id;

                    $occupantA = Occupant::find($occId)->amenities()->get();
                }

                return view('tenant.dashboard',compact('user','occupantA'));  
            }	  
		}
    }
    
    public function reservationEdit($id)
    {
    	$reservation = Reservation::find($id);

        $checkInDate = \Carbon\Carbon::parse($reservation->check_in);
        $checkOutDate = \Carbon\Carbon::parse($reservation->check_out);

        $formatCheckIn = $checkInDate->toDateString();
        $formatCheckOut =  $checkOutDate->toDateString();

        $rooms = \DB::table('rooms')
        ->where('status','<>','Full')
        //->Where('status','=','Occupied')
            ->whereNotIn('id', function($query) use ($formatCheckIn,$formatCheckOut)
             {
                $query->select('room_id')
                    ->from(with(new Reservation)->getTable())
                    ->where(function($query) use ($formatCheckIn,$formatCheckOut)
                    {
                        $query
                        ->where('status','<>','Cancel')
                        ->where('check_out','<',$formatCheckOut)
                        ->orWhere('check_in','>',$formatCheckIn)
                        ->where('check_out','<=',$formatCheckOut)
                        ->orWhere('check_in','>=',$formatCheckIn)
                            ;
                    });
             })
            ->orderBy('type')
            ->get();

    	return view('client.edit',compact('reservation','rooms','format'));
    }

    public function reseveEdit(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        $validatedData = $request->validate([
        'room_id'   => 'required',
        'start_date' => 'required|date', 
        ]);

        $getDate = \Carbon\Carbon::parse($request->start_date);
        $getDate2 = \Carbon\Carbon::parse($request->check_out);

        $check_in = $getDate->toDateString();
        $check_out = $getDate2->toDateString();

    	$reservation->check_in = $check_in;
        $reservation->check_out = $check_out;
    	$reservation->room_id  = $request->room_id;
    	$reservation->save();

        Session::flash('message','Reservation successfully updated!');

        return redirect('/client');

    }

    public function cancelReserv($id)
    {
        $reservation = Reservation::find($id);
        
        $reservation->status = 'Cancel';

        if($reservation->save())
        {
          return response()->json(['success' => true, 'msg' => 'Reservation successfully canceled!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while canceling reservation!']);
        }  
    }
}
