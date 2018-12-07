<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Room;
use App\Amenities;
use Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon; 

class ManageUsersController extends Controller
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
    public function index()
    {
        return view('admin.manage-users.index');
    }

    //Active user Datatable
    public function getUsersDatatable()
    {
      $userActive = User::select(['id','firstname','lastname','street_ad','city','province','dob','email','contact_no','username','status','role','verified'])
      ->where(function($userActive){
        $userActive->where('status','=','Active');
      });
      return Datatables::eloquent($userActive)
      ->addColumn('name', function($user){
        return $user->full_name;
      })
      ->addColumn('dob', function($user){
        $dateFormat = Carbon::parse($user->dob);
        $dateReserv = $dateFormat->toFormattedDateString();
        return $dateReserv;
      })
      ->addColumn('address', function($user){
      return $user->address();
      })
      ->addColumn('action', function($user){
        return '<button class="btn btn-success btn-sm edit-data-btn" data-id="'.$user->id.'">
                <i class="fa fa-edit"></i></a>
                </button>';        
      })
      ->addColumn('verified', function($user){
        if($user->verified == 1)
        {
          return 'Yes'; 
        }
        else
        {
          return 'No'; 
        }
               
      })
      ->make(true);
    }

    //Inactive user Datatable
    public function inactiveUser()
    {
      $userInactive = User::select(['id','firstname','lastname','street_ad','city','province','dob','email','contact_no','username','status','role'])
      ->where(function ($userInactive){
        $userInactive->where('status','=','Inactive');
      });
      return Datatables::of($userInactive)
      ->addColumn('name', function($user){
      return $user->full_name;
      })
      ->addColumn('dob', function($user){
      $dateFormat = Carbon::parse($user->dob);
      $dob = $dateFormat->toFormattedDateString();
      return $dob;
      })
      ->addColumn('address', function($user){
      return $user->address();
      })
      ->addColumn('action', function($user){
      return 
      '<button class="btn btn-info btn-sm setActive-data-btn" data-id="'.$user->id.'">
      Set Active
      </button>

      <button class="btn btn-danger btn-sm delete-data-btn" data-id="'.$user->id.'">
      <i class="fa fa-archive"></i>
      </button>';
      })
      ->addColumn('verified', function($user){
        if($user->verified == 1)
        {
          return 'Yes'; 
        }
        else
        {
          return 'No'; 
        }
               
      })
      ->make(true);
    }

    public function create()
    {
      $amenity = Amenities::all();

      $rooms = Room::where('status','Available')->get();

      return view('admin.manage-users.create',compact('rooms','amenity'));
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
      'firstname'     => 'required|max:25',
      'lastname'      => 'required|max:25',
      'street_ad'     => 'required|max:50',
      'city'          => 'required|max:25',
      'province'      => 'required|max:25',
      'contact_no'    => 'required|regex:/(09)[0-9]{9}/|size:11',
      'dob'           => 'required|date',
      'email'         => 'required|email|unique:users',
      'username'      => 'required|unique:users',
      'role'          => 'required',
      'password'      => 'required',
      ]);

      $users = new User;
      $users->firstname = ucfirst($request->firstname);
      $users->lastname  = ucfirst($request->lastname);
      $users->street_ad = $request->street_ad;
      $users->city      = $request->city;
      $users->province  = $request->province;
      $users->contact_no= $request->contact_no;
      $users->dob       = $request->dob;
      $users->email     = $request->email;
      $users->username  = $request->username;
      $users->password  = bcrypt($request->password);
      $users->role      = $request->role;
      
      if($users->save())
      {
        return response()->json(['success' => true, 'msg' => 'User Successfully added!']);
      }
      else
      {
        return response()->json(['success' => false, 'msg' => 'An error occured while adding user!']);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = User::findOrFail($id);

      return view('admin.manage-users.edit',compact('user'));
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
        $validatedData = request()->validate([
        'firstname'     => 'required|max:25',
        'lastname'      => 'required|max:25',
        'street_ad'     => 'required|max:50',
        'city'          => 'required|max:25',
        'province'      => 'required|max:25',
        'contact_no'    => 'required|regex:/(09)[0-9]{9}/|size:11',
        'dob'           => 'required|date',
        'email'         => 'required|email',
        'username'      => 'required',
        'status'        => 'required',
        'role'          => 'required',
        'password'      => 'nullable|confirmed'
        ]);

        $user = User::find($id); 

        $user->firstname = $request->firstname; 
        $user->lastname  = $request->lastname;
        $user->street_ad = $request->street_ad;
        $user->city      = $request->city;
        $user->province  = $request->province;
        $user->contact_no= $request->contact_no;
        $user->dob       = $request->dob; 
        $user->email     = $request->email;
        $user->username  = $request->username;
        $user->status    = $request->status;
        $user->role      = $request->role;
        if($request->password != '')
        {
          $user->password  = bcrypt($request->password);
        } 
        
        if($user->save())
        {
          return response()->json(['success' => true, 'msg' => 'User Successfully updated!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while updating user!']);
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
      if(Auth::user()->id == $id)
      {
        return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
      }
      else
      {
        if(User::destroy($id))
        {
          return response()->json(['success' => true, 'msg' => 'Data Successfully deleted!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while deleting data!']);
        } 
      }
    }

    public function setActive($id)
    {
      if(Auth::user()->id == $id)
      {
        return response()->json(['success' => false, 'msg' => 'An error occured while inactivating user!']);
      }
      else
      {
        $user = User::find($id);

        $user->status = 'Active';

        $user->role = 'Client';

        if($user->save())
        {
          return response()->json(['success' => true, 'msg' => 'User Successfully Activated!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while activating user!']);
        }
      } 
    }    
}
