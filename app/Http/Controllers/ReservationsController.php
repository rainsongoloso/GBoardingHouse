<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Reservation;
use App\User;
use App\Room;
use App\Amenities;
use App\Financial;
use Carbon\Carbon;
use App\Occupant;
use Session;

class ReservationsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
        return view('admin.reservation.index');
    }

    public function reservationDatatable()
    {
        // $activeReservation = Reservation::where('status','Active')->orWhere('status', 'Settled');
        $activeReservation = Reservation::latest()->get();

        return Datatables::of($activeReservation)
        ->addColumn('action', function($reservation){
        if($reservation->status != 'Settled' && $reservation->status != 'Cancel' )
        {
        return '<button class="btn btn-success edit-data-btn" data-id="'.$reservation->id.'">
        <i class="fa fa-edit"></i></a>
        </button>

        <button class="btn btn-info settle-data-btn" data-id="'.$reservation->id.'">
        <i class="fa fa-credit-card"></i></a>
        </button>

        <button class="btn btn-warning cancel-data-btn" data-id="'.$reservation->id.'">
        <i class="fa fa-remove"></i></a>
        </button>
        ';  
        }

        })
        ->addColumn('roomNo', function($reservation)
        {
            return $reservation->room->room_no;
        })
        ->addColumn('roomType', function($reservation)
        {
            return $reservation->room->type;
        })
        ->addColumn('user', function($reservation)
        {
            return $reservation->user->id ." - ". $reservation->user->full_name;
        })
        ->addColumn('amenity', function($reservation)
        {
            if($reservation->amenity == null)
            {
                return 'None';
            }
            else
            {
                return $reservation->amenity->name;     
            }
        })
        ->addColumn('dateReserv', function($reservation)
        {   
            $dateFormat = Carbon::parse($reservation->created_at);
            $dateReserv = $dateFormat->toDayDateTimeString();
            return $dateReserv;
        })
        ->addColumn('startDate', function($reservation)
        {   
            $dateFormat = Carbon::parse($reservation->start_date);
            $dateStart = $dateFormat->toFormattedDateString();
            return $dateStart;
        })
        ->make(true);
    }

    public function addResevation()
    {
        $users = User::where('role','Client')->where('status','Active')->get();

        $rooms = Room::where('status','Available')->get();
        
        // ->where('flag', 0)

        $amenities = Amenities::all();

        return view('admin.reservation.add-reservation-form',compact('users','rooms','amenities'));
    }

    public function storeReservation(Request $request)
    {   
        $data = request()->validate([
          'user_id'     => 'required|max:25',
          'room_id'     => 'required|max:25',
          // 'status'      => 'required|max:50',
          // 'amenities'   => 'max:15|nullable',
          'start_date'  => 'required|max:15',
          'downpay'     => 'nullable'    
        ]); 

        $reservation = new Reservation;
        $reservation->user_id = $request->user_id;
        $reservation->room_id = $request->room_id;
        // $reservation->status  = $request->status;
        // $reservation->amenities_id = $request->amenities;
        $reservation->start_date = $request->start_date;
        if($request->advance == true)
        {
            $reservation->downpay = 1;
        }

        if($reservation->save())
        {
          return response()->json(['success' => true, 'msg' => 'Reservation Successfully added!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while adding reservation!']);
        }
    }

    public function editReservation($id)
    {
        $reservation = Reservation::find($id);

        // $users = User::where('user_id','Active')->first();

        // $newRoom = new Room;
        // $getRoomCapacity = $newRoom->max_capacity;

        $rooms = Room::where('status','Available')->get();

        $amenities = Amenities::all();

        // $amenities = Amenities::all();

        return view('admin.reservation.change_date_reservation',compact('reservation','rooms','amenities'));
    }

    public function storeEditReservation(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        // $reservation->user_id = $request->user_id;
        $reservation->room_id = $request->room_id;
        // $reservation->amenities_id = $request->amenities;
        $reservation->start_date = $request->start_date;
        // $reservation->status = $request->status; 
        if($reservation->save())
        {
          return response()->json(['success' => true, 'msg' => 'Reservation successfully updated!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while updating reservation!']);
        } 
    }

    public function cancel($id)
    {
        $reservation = Reservation::find($id);
        
        $reservation->status = 'Cancel';

        if($reservation->save())
        {
          return response()->json(['success' => true, 'msg' => 'reservation Canceled!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while canceling reservation!']);
        }  
    }

    public function formPay($id)
    {
        $reservation = Reservation::find($id);

        return view('admin.reservation.payReservation',compact('reservation'));
    }

    public function payResevation(Request $request, $id)
    {
        $validatedData = $request->validate([
        // 'payment_for' => 'required',
        'remarks' => 'required',
        'amountPay' =>'required'
        ]);

        // $monthToPay = Carbon::parse($request->payment_for);
        // $now = Carbon::now();
        // $month = $monthToPay->diffInMonths($now);
        
        $reservation = Reservation::find($id);

        $room = Room::find($reservation->room_id);

        $startdate = Carbon::parse($reservation->start_date);

        $addmonth = $startdate->addMonths(1);

        // $format = $addmonth->toDateTimeString();

        // dd($format);

        // if( $reservation->start_date > 0)
        // {
        switch ($request->remarks) 
        {
        case "Advance payment":
            //if private room->rate as is if bed spacer rate/max_capacity

            if($reservation->room->type == 'Private')
            {
                $amountTobe = $reservation->room->rate;
                // * $month
            }
            //bed spacer
            else
            {
                $amountTobe = $reservation->room->rate / $reservation->room->max_capacity;
                // * $month
            }

            //if ammount is less than 
            if($request->amountPay < $amountTobe)
            {     
                return response()->json(['success' => false, 'msg' => 'Insufficient funds, amount to be paid '.$amountTobe.'']);
            }

            break;
        case "Deposit":
            //if private type room->rate as is
            if($reservation->room->type == 'Private')
            {
                $amountTobe = $reservation->room->rate * .50 ;
                // * $month;
            }
            else
            {
                $amountTobe = $reservation->room->rate / $reservation->room->max_capacity * .50;
                // * $month;
            }

            //ammount to be paid
            if($request->amountPay < $amountTobe)
            {
                return response()->json(['success' => false, 'msg' => 'Insufficient funds, must pay at least 50%'.$amountTobe.'']);
            }
            break;
        default: 

            return response()->json(['success' => false, 'msg' => 'Choose a remarks']);
        }

        $getReservUserId = $reservation->user_id;

        $getReservRoomId = $reservation->room_id;

        $room = Room::find($reservation->room_id);

        $occupant = new Occupant;

        $occupant->flag = 1;

        $occupant->user_id = $getReservUserId;

        $occupant->room_id = $getReservRoomId; 

        $occupant->save();

        $user = User::find($getReservUserId);

        $user->role = "Tenant";

        $user->save();
        
        $occuId = $occupant->id;

        $financial = new Financial;

            if($room->type == "Private")
            {
                $getRoomRate = $room->rate;

                $getRoomCcap = $room->current_capacity;

                //add the current capacity of the room
                $room->current_capacity = $getRoomCcap+1;

                //change it to Unavailable cause it is private room
                $room->status = 'Unavailable';

                //put it to the financial occupant_id column
                $financial->occupant_id = $occuId;

                $financial->remarks = $request->remarks;

                $financial->payment_for = $addmonth;

                // $request->payment_for

                //$financial->debit = $getRoomRate; 

                $financial->credit = $request->amountPay;  
            }
            else
            //bed spacer
            {
                $getRoomRate = $room->rate / $room->max_capacity;

                $getRoomCcap = $room->current_capacity;

                $room->current_capacity = $getRoomCcap+1;

                if($room->current_capacity > 0)
                {
                    $room->status = 'Occupied';
                }

                if($room->current_capacity >= $room->max_capacity)
                {
                    $room->status = 'Full';
                }

                $financial->occupant_id = $occuId;

                $financial->remarks = $request->remarks;

                $financial->payment_for = $addmonth;

                // $request->payment_for

                //$financial->debit = $getRoomRate; 

                $financial->credit = $request->amountPay;
            }

        $reservation->status = "Settled";

        //if true reservation save
        if($reservation->save())
        {
            //if true room save
            if($room->save())
            {
              //if true financial save
              if($financial->save())
              {
                return response()->json(['success' => true, 'msg' => 'Reservation successfully settled']); 
              }
              else
              {
                return response()->json(['success' => false, 'msg' => 'Error in settling reservation']);
              }   
            }
            else
            {
                return response()->json(['success' => false, 'msg' => 'Error in settling reservation']);
            }
        }
        else
        {
            return response()->json(['success' => false, 'msg' => 'Error in settling reservation']);
        }        
    }
    // else
    // {
    //     return response()->json(['success' => false, 'msg' => 'At least 1 month']);
    // }
    //}
}

