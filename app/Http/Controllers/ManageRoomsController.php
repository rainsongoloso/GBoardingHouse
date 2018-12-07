<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\User;
use App\Occupant;
use Validator;
use Session;
use Yajra\DataTables\Facades\DataTables;
use App\RoomCapacity;
use Image;
use Storage;

class ManageRoomsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['isAdmin','isActive','auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.manage-rooms.index');
    }

    public function getRoomsDatatable()
    {
        $rooms = Room::all();

        return Datatables::of($rooms)
        ->addColumn('created', function($room){

            $toBe = $room->created_at;
            $format = $toBe->toDayDateTimeString();
            return $format;
        })
        ->addColumn('updated', function($room){

            $toBe = $room->updated_at;
            $format = $toBe->toDayDateTimeString();    
            return $format;
        })
        ->addColumn('capacity', function($room){
            
            return $room->current_capacity .'/'. $room->max_capacity;
        })
        ->addColumn('rates', function($room){
           
           return $room->roomRate();
        })
        ->addColumn('action', function($room){
        return '<button class="btn btn-success btn-sm edit-data-btn" data-id="'.$room->id.'">
                <i class="fa fa-edit"></i></a>
                </button> 

                <button class="btn btn-info btn-sm view-data-btn" data-id="'.$room->id.'">
                     <i class="fa fa-eye"></i>
                </button>  

                <button class="btn btn-danger btn-sm delete-data-btn" data-id="'.$room->id.'">
                     <i class="fa fa-trash"></i>
                </button>       
                ';
        })
        ->make(true);
    }

    // <button class="btn btn-danger assign-data-btn" data-id="'.$room->id.'">
    //                 <i class="fa fa-trash">Assign Tenant</i>
    //             </button>
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manage-rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
        'room_no'     => 'required|unique:rooms',
        'status'      => 'required',
        'type'        => 'required',
        'max_capacity'=> 'required|numeric',
        'rate'        => 'required|regex:/^\d*(\.\d{1,2})?$/',
        'description' => 'required',
        'room_image'  => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',    
        ]);

        $room = new Room;
        $room->room_no          = $request->room_no;
        $room->status           = $request->status;
        $room->type             = $request->type;
        $room->max_capacity     = $request->max_capacity;
        $room->rate             = $request->rate;
        $room->description      = $request->description; 

        if($request->hasFile('room_image'))
        {   
            $room_image = $request->file('room_image');
            $filename = time() . '.' . $room_image->getClientOriginalExtension();
            Image::make($room_image)->resize(368,260)->save( public_path('/images/room_image/' . $filename) );
            $room->room_image = $filename;
        }
     
        if($room->save())
        {
          return response()->json(['success' => true, 'msg' => 'Room Successfully added!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while adding room!']);
        }      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);

        // $roomWithOccupants = Room::find($id)->occupants()->where('flag','1')->get();

        $occupants = Occupant::with('user')->where('flag', 1)->where('room_id', $room)->get();
        // ->where('room_id','=', $room)->where('flag', 1)->get();

        return view('admin.manage-rooms.view',compact('room','occupants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
    
        return view('admin.manage-rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $data = request()->validate([
        'room_no'     => 'required',
        'status'      => 'required',
        'room_image'  => 'image',
        'type'        => 'required', 
        'max_capacity'=> 'required|numeric',
        'rate'        => 'required|regex:/^\d*(\.\d{1,2})?$/',
        'description' => 'required',
        ]);

        $room = Room::find($id);
        $room->room_no  = $request->get('room_no');  
        $room->status  = $request->get('status');  
        $room->type  = $request->get('type');  
        $room->max_capacity  = $request->get('max_capacity');  
        $room->rate  = $request->get('rate');  
        $room->description  = $request->get('description');
          
       if($request->hasFile('room_image'))
        {   
            $room_image = $request->file('room_image');
            $filename = time() . '.' . $room_image->getClientOriginalExtension();
            Image::make($room_image)->resize(368,260)->save( public_path('/images/room_image/' . $filename) );
            $room->room_image = $filename;

        }
        if($room->save())
       // if(Room::find($id)->update($data))
        {
            // for($i=1; $i<= $request->max_capacity; $i++){
            //     $room = Room::find($id);    
            //     $roomcapacity = new RoomCapacity;
            //     $roomcapacity->room_id = $room->id;
            //     $roomcapacity->save();
            // }
            
          return response()->json(['success' => true, 'msg' => 'Room Successfully updated!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while updating room!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $room = Room::find($id);
      if($room->current_capacity > 0)
      {
        return response()->json(['success' => false, 'msg' => 'Room cannot be deleted']);
      }
      else
      {
        if(Room::destroy($id))
        {
        return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
        }
        else
        {
        return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        }  
      }
      
    }  
}