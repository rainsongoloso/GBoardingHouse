<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Room;
use App\User;
use App\Occupant;
use App\Amenities;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Reservation;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['isAdmin','isActive','auth']);
    }
    
    public function index()
    {
    	$rooms = Room::all();

        $amen = Amenities::all();

    	$users = User::where('role','Tenant')->get();

        $getNow = \Carbon\Carbon::now();
        $toString = $getNow->toDateString();
        $totalReserv = Reservation::whereDate('created_at',$toString)->where('status','Active')->count('id');

    	return view('admin.dashboard.index',compact('rooms','users','amen','totalReserv'));
    }

    public function occupantsDatatable()
    {
        // $occupants = Occupant::where('flag', 1)->orderBy('room_id','asc')->get();

        $occupants = Occupant::all();

        return Datatables::of($occupants)
        ->addColumn('name', function($occupant)
        {
            return $occupant->user->full_name;
        })
        ->addColumn('roomType', function($occupant)
        {
            return $occupant->room->type;
        })
        ->addColumn('room_no', function($occupant)
        {
            return $occupant->room->room_no;
        })
        ->addColumn('amenity', function($occupant)
        {

            if(count($occupant->amenities) > 0)
            {
                $amenities = $occupant->amenities;
                foreach ($amenities as $amenity) 
                {
                    $toArray[] = $amenity->amen_name; 
                }
                return $toArray;  
            }
            else
            {
                return 'None';  
            }
        })
        ->addColumn('started', function($occupant)
        {
            // if($occupant->user->reservation != null)
            // {
            //     $occupanter = $occupant->user->reservation->check_in;

            //     $formatDate = Carbon::parse($occupanter);

            //     $dateStarted = $formatDate->toFormattedDateString();

            //     return $dateStarted;
            // }
            // else
            // {
                $formatDate = Carbon::parse($occupant->start_date);

                $dateStarted = $formatDate->toFormattedDateString();

                return $dateStarted;
            //}
        })
        ->addColumn('end_date', function($occupant)
        {
            if($occupant->end_date != null)
            {
                $formatDate = Carbon::parse($occupant->end_date);

                $dateEnd = $formatDate->toFormattedDateString();

                return $dateEnd;
            }
            else
            {
                return " ";
            }
        })
        ->addColumn('action', function($occupant){       
        if($occupant->flag == 1)
        {
           return 
        '<button class="btn btn-success btn-sm edit-data-btn" data-id="'.$occupant->id.'" data-toggle="tooltip" data-placement="left" title="Change Room">Change room
        </button>

        <button class="btn btn-info btn-sm avail-data-btn" data-id="'.$occupant->id.'" data-toggle="tooltip" data-placement="right" title="Avail Amenity">Avail/Change amenity
        </button>

        <button class="btn btn-danger btn-sm leave-data-btn" data-id="'.$occupant->id.'" data-toggle="tooltip" data-placement="top" title="leave tenant">Check out
        </button>';   
        }
        else
        {   
            return "Checked out";
        }      
        
        })
        ->make(true);
    }

    public function changeRoom($id)
    {
       $occupant = Occupant::find($id);
       $rooms = Room::where('status', 'Available')->orWhere('status','Occupied')->orderBy('type')->get();
       return view('admin.dashboard.changeRoom',compact('occupant','rooms'));     
    }


    public function roomChanged(Request $request, $id)
    {
        $occupantA = Occupant::find($id)->amenities()->get();
            
        foreach ($occupantA as $occ) 
        {                         
            if($occ->id == 2 && $occ->amen_name == 'Aircon')
            {
                return response()->json(['success' => false, 'msg' => 'Error! Room cannot be change. Aircon is availed']);
            }
        }

        $occupants = Occupant::find($id);

        //getRoomID
        $getRoomId = $occupants->room_id;

        //getUserId
        $getUserId = $occupants->user_id;

        //Get the occupant room_id == to Room room_id
        $room = Room::find($getRoomId);

        $getCurr = $room->current_capacity;

        if($room->type == 'Private')
        {
            $room->current_capacity = $getCurr-1;

            $room->status = "Available";
        }
        //bedspacer
        else
        {
            $room->current_capacity = $getCurr-1;

            if($room->current_capacity == 0)
            {
                $room->status = "Available";
            }
            else
            {
                $room->status = "Occupied";
            } 
        }
        $room->save();

        $data = request()->validate([
        'room_id' => 'required',
        'user_id' => 'required'
        ]);

        Occupant::findOrFail($id)->update($data);

        $room2 = Room::find($request->room_id);

        $getRoomCurr = $room2->current_capacity;   

        if($room2->type == 'Private')
        {
            $room2->current_capacity = $getRoomCurr+1;

            $room2->status = "Full";
        }
        else
        {
            $room2->current_capacity = $getRoomCurr+1;

            if($room2->current_capacity >= $room2->max_capacity)
            {
                $room2->status = "Full";
            }
            else
            {
                $room2->status = "Occupied";
            } 
        }

        if($room2->save())
        {
          return response()->json(['success' => true, 'msg' => 'Room Successfully changed!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while changing room!']);
        }
    }   

    public function availAmenity($id)
    {
        $occupant = Occupant::find($id);
        $amenities = Amenities::all();
        $amenities2 = array();
        foreach ($amenities as $amenity) 
        {
           $amenities2[$amenity->id] = $amenity->amen_name; 
        }       

        return view('admin.dashboard.avail_amenity')->withOccupant($occupant)->withAmenities($amenities2);
    }

    public function availed(Request $request, $id)
    {
        $occupant = Occupant::find($id);
        
        $occupantr = $occupant->room->type;



        if($occupantr == 'Bed Spacer')
        {
            if(count($request->amenities) > 0 )
            {
                foreach ($request->amenities as $key) 
                {
                    if($key == 2)
                    {
                        return response()->json(['success' => false, 'msg' => 'Aircon cannot be availed by bedspacers']);
                    }
                }
            } 

            if(isset($request->amenities))
            {
              if($occupant->amenities()->sync($request->amenities))
                {
                return response()->json(['success' => true, 'msg' => 'Amenity Successfully availed']);
                }
                else
                {
                    return response()->json(['success' => false, 'msg' => 'An error occured while availing/changing amenities!']);   
                }  
            }
            else
            {
                $occupant->amenities()->sync(array());

                return response()->json(['success' => true, 'msg' => 'No amenities availed']);
            }        
                
        }
        else
        {
            if(isset($request->amenities))
            {
              if($occupant->amenities()->sync($request->amenities))
                {
                return response()->json(['success' => true, 'msg' => 'Amenity Successfully availed']);
                }
                else
                {
                    return response()->json(['success' => false, 'msg' => 'An error occured while availing/changing amenities!']);   
                }  
            }
            else
            {
                $occupant->amenities()->sync(array());
            }
        }

        
    }

    public function leaveTenant($id)
    {
        $occupants = Occupant::find($id)->financials;

        $occupanted = Occupant::find($id);

        foreach($occupants as $occupant)
        {
            if($occupant->totalBalance() < 0)
            {
               return response()->json(['success' => false, 'msg' => 'Occupant still have balance']);
            }
        }
            
       $occupanted->flag = 0;

       $today = \Carbon\Carbon::now();

       $occupanted->end_date = $today;

       $occupanted->save();

        if($occupanted->save())
        {
           //Occupant-> ROOM ID = Room->Room_id
            $getRoomIdFromOccupant = $occupanted->room_id;

            $room = Room::find($getRoomIdFromOccupant);

            $minusOne = $room->current_capacity;

            if($room->type == 'Private')
            { 
                $room->status = "Available";

                $room->current_capacity = $minusOne-1;
            }
            //bedspacer
            else
            {
                $room->current_capacity = $minusOne-1;

                if($room->current_capacity == 0)
                {
                    $room->status = "Available";
                }
                else
                {
                    $room->status = "Occupied";
                } 
            }
                    
                if($room->save())
                {
                //User Table User_id == Occupant Table User id
                $getUserIdFromOccupant = $occupanted->user_id;

                $user = User::find($getUserIdFromOccupant);

                $user->role = 'Client';

                $user->status = 'Inactive';

                    if($user->save()) 
                    {
                      return response()->json(['success' => true, 'msg' => 'Occupant Successfully checked out!']);  
                    }
                    else
                    {
                      return response()->json(['success' => false, 'msg' => 'An error occured while leaving occupant!']);  
                    } 
                }
                else
                {
                    return response()->json(['success' => false, 'msg' => 'An error occured while leaving occupant!']);
                } 
        }
        else
        {
            return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }              
    }

    public function assignClient()
    {
        $users = User::where('role','<>','Admin')->where('status','Active')->get();

        $rooms = Room::where('status','Available')->orWhere('status','Occupied')->orderBy('type')->get();

        $amenities = Amenities::all();

        return view('admin.dashboard.occupantForm',compact('users','rooms','amenities'));
    } 

    public function storeAssign(Request $request)
    {      
        $validatedData = request()->validate([
        'user_id'     => 'required',
        'room_id'      => 'required',
        ]);

        $occupant = new Occupant;
        $occupant->user_id = $request->user_id;
        $occupant->room_id = $request->room_id;
        
        $occupant->flag = 1;
        
        if($occupant->save())
        {
            $room = Room::find($request->room_id);
        
            $addCcap = $room->current_capacity; 
          
              if($room->type == 'Private')
              {
                $room->current_capacity = $addCcap+1;

                $room->status = 'Full';
              }
              //bedspacer
              else
              {
                $room->current_capacity = $addCcap+1;

                if($room->current_capacity >= $room->max_capacity)
                {
                    $room->status = 'Full';
                }
                else
                {
                    $room->status = 'Occupied';
                }
              }

            if($room->save())
            {
                $userSetTenant = User::find($request->user_id);
                $userSetTenant->role = "Tenant";

                if($userSetTenant->save())
                {
                  return response()->json(['success' => true, 'msg' => 'Occupant Successfully added!']);  
                }
                else
                {
                    return response()->json(['success' => false, 'msg' => 'An error occured while updating room!']);     
                }
            }
            else
            {
                return response()->json(['success' => false, 'msg' => 'An error occured while updating room!']);
            }
        }
        else
        {
            return response()->json(['success' => false, 'msg' => 'An error occured while updating occupant!']);
        }
    }

    // public function chart()
    // {
    //     $reservation = Reservation::select(DB::raw("Count(id) as idcount"))
    //     ->orderBy("created_at")
    //     ->groupBy(DB::raw("month(created_at)"))
    //     ->get()
    //     ->toArray();

    //     $reservation = array_column($reservation, 'idcount');

    //     return view('admin.dashboard.index')->with('reservation',json_encode($reservation,JSON_NUMERIC_CHECK));
    // }                       
}

