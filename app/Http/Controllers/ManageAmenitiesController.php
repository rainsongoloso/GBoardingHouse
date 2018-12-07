<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Amenities;
use App\Occupant;
use Validator;
use Session;
use Yajra\DataTables\Facades\DataTables;

class ManageAmenitiesController extends Controller
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
        return view('admin.manage-amenities.index');
    }

    public function getAmenitiesDatatable()
    {
        return Datatables::eloquent(Amenities::query())->addColumn('action', function($amen){
        return '<button class="btn btn-success btn-sm edit-data-btn" data-id="'.$amen->id.'">
                <i class="fa fa-edit"></i></a>
                </button>

                <button class="btn btn-danger btn-sm delete-data-btn" data-id="'.$amen->id.'">
                    <i class="fa fa-trash"></i>
                  </button>
                ';
        })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manage-amenities.create');
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
        'amen_name' => 'required|max:25',
        'rate' => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
        'description' => 'required|max:50'
        ]);

        $amen = new Amenities;
        $amen->amen_name   = $request->amen_name;
        $amen->rate        = $request->rate;
        $amen->description = $request->description;

        if($amen->save())
        {
            return response()->json(['success' => true, 'msg' => 'Amenity Successfully added!']);
        }
        else
        {
            return response()->json(['success' => false, 'msg' => 'An error occured while adding amenity!']);
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
        $amen = Amenities::findOrFail($id);
        return view('admin.manage-amenities.edit',compact('amen'));
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
        'amen_name' => 'required',
        'rate'        => 'required|numeric|regex:/^\d*(\.\d{1,2})?$/',
        'description' => 'required|max:50'
        ]);

        if(Amenities::find($id)->update($data))
        {
          return response()->json(['success' => true, 'msg' => 'Amenity Successfully updated!']);
        }
        else
        {
          return response()->json(['success' => false, 'msg' => 'An error occured while updating amenity!']);
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

    try {

      if(Amenities::destroy($id))
      {
      return response()->json(['success' => true, 'msg' => 'Amenity Successfully deleted!']);
      }
      else
      {
      return response()->json(['success' => false, 'msg' => 'An error occured while deleting amenity!']);
      }
            
    }
    catch (\Illuminate\Database\QueryException $e) 
    {
        if($e)
        {
            return response()->json(['success' => false, 'msg' => 'Amenity cannot be deleted']);      
        }
            
    }

       
    }
}
