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
        $activeReservation = Reservation::latest()->get();

        return Datatables::of($activeReservation)
        ->addColumn('action', function($reservation){
        if($reservation->status != 'Settled' && $reservation->status != 'Cancel' )
        {
        return '<button class="btn btn-success btn-sm edit-data-btn" data-id="'.$reservation->id.'">
        <i class="fa fa-edit"></i></a>
        </button>

        <button class="btn btn-info btn-sm settle-data-btn" data-id="'.$reservation->id.'">
        <i class="fa fa-credit-card"></i></a>
        </button>
      
        <button class="btn btn-danger btn-sm delete-data-btn" data-id="'.$reservation->id.'">
        <i class="fa fa-trash"></i></a>
        </button>
        ';
        }
        else
        {
            return '<button class="btn btn-danger btn-sm delete-data-btn" data-id="'.$reservation->id.'">
        <i class="fa fa-trash"></i></a>
        </button>';
        }
        //   <button class="btn btn-warning btn-sm cancel-data-btn" data-id="'.$reservation->id.'">
        // <i class="fa fa-remove"></i></a>
        // </button>

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
        ->addColumn('dateReserv', function($reservation)
        {   
            $dateFormat = Carbon::parse($reservation->created_at);

            $phpformat = date("M d, Y", strtotime($reservation->created_at));
            return $phpformat;
        })
        ->addColumn('startDate', function($reservation)
        {   
            $dateFormat = Carbon::parse($reservation->check_in);
            $dateStart = $dateFormat->toFormattedDateString();
            return $dateStart;
        })
        ->addColumn('checkOut', function($reservation)
        {   
            $dateFormat = Carbon::parse($reservation->check_out);
            $checkOut = $dateFormat->toFormattedDateString();
            return $checkOut;
        })
        ->make(true);
    }

    public function addResevation()
    {
        $users = User::where('role','Client')->where('status','Active')->get();

        $rooms = Room::where('status','Available')->orWhere('status','Occupied')->orderBy('type')->get();

        $amenities = Amenities::all();

        return view('admin.reservation.add-reservation-form',compact('users','rooms','amenities'));
    }

    public function storeReservation(Request $request)
    {   
        $data = request()->validate([
          'user_id'     => 'required|max:25',
          'room_id'     => 'required|max:25',
          'start_date'  => 'required',
          'check_out'   => 'required'   
        ]); 

        $getDate = \Carbon\Carbon::parse($request->start_date);
        $getDate2 = \Carbon\Carbon::parse($request->check_out);
        $formatDate = $getDate->toDateString();
        $formatDate2 = $getDate2->toDateString();

        $reservation = new Reservation;
        $reservation->user_id = $request->user_id;
        $reservation->room_id = $request->room_id;
        $reservation->check_in = $formatDate;
        $reservation->check_out = $formatDate2;

        $holdDate = $getDate->day;
        $holdMonth = $getDate->month;
        $holdDate2 = $getDate2->day;
        $holdMonth2 = $getDate2->month;

        if($holdDate == $holdDate2 || $holdMonth == $holdMonth2)
        {
            return response()->json(['success' => false, 'msg' => 'Check in date and Check out date must not be the same and atleast 1 month of check out']);
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

        $rooms = Room::where('status','Available')->orWhere('status','Occupied')->get();

        $amenities = Amenities::all();

        return view('admin.reservation.change_date_reservation',compact('reservation','rooms','amenities'));
    }

    public function storeEditReservation(Request $request, $id)
    {
        $reservation = Reservation::find($id);
        $reservation->room_id = $request->room_id;
        $reservation->check_in = $request->start_date;
        $reservation->check_out = $request->check_out; 
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
        
        $reservation = Reservation::find($id);

        $room = Room::find($reservation->room_id);

        $startdate = Carbon::parse($reservation->check_in);

        $addmonth = $startdate->addMonths(1);

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

        $getReservCheckIn = $reservation->check_in;

        $getReservCheckOut = $reservation->check_out;

        $room = Room::find($reservation->room_id);

        $occupant = new Occupant;

        $occupant->flag = 1;

        $occupant->user_id = $getReservUserId;

        $occupant->room_id = $getReservRoomId;

        $occupant->start_date = $getReservCheckIn;

        // $occupant->end_date = $getReservCheckOut;     

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
                $room->status = 'Full';

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

    public function destroy($id)
    {
        if(Reservation::destroy($id))
        {
          return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }
    }
}

