<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Financial;
use App\User;
use App\Room;
use App\Occupant;
use App\Amenities;
use App\Reservation;
use Carbon\Carbon;
use Session;

class BillingController extends Controller
{
	public function __construct()
    {
        $this->middleware(['isAdmin','isActive','auth']);
    }
    
    public function index()
    {  
        $occupants = Occupant::where('flag',1)->get();

        return view('admin.financial.index',compact('occupants'));
    }

    public function financial_table(Request $request)
    {
        if($request->occupant == 0)
        {
            Session::flash('validate','Please choose a Tenant');
            return redirect('/billing/index');
        }
        else
        {
          $occupants = Occupant::where('flag',1)->get();
          
          $occupanter = Occupant::find($request->occupant)->financials;

          $financial = Occupant::find($request->occupant);

          $financial2 = Occupant::find($request->occupant)->financials->sum('credit');

          $financial3 = Occupant::find($request->occupant)->financials->sum('debit');

          $balance = $financial2 - $financial3;

           return view('admin.financial.financials_table',compact('occupants','occupanter','financial','balance'));  
        } 
    }

    public function automateBill()
    {
        $today = \Carbon\Carbon::now();

        $format = $today->toDateString(); 

        $ocF = Occupant::with('financials')
        ->where('flag',1)
        ->whereHas('financials', function($query) use ($format){
            $query->where('payment_for','2018-03-13');
        })
        ->get();
    
        foreach ($ocF as $oc) {

            $occupant = Occupant::find($oc->id);
        
            $rRoom = $occupant->room->roomRate();

            if($occupant->isNull())
            {
                $totalRate = $rRoom + $occupant->amenity->rate;   
            }
            else
            {   
                $totalRate = $rRoom;
            }

            $financial = new Financial;

            $financial->occupant_id = $oc->id;

            $financial->status = 'Unpaid';

            $financial->remarks = 'Rent';

            $addMonth = \Carbon\Carbon::now();

            $financial->payment_for = $addMonth->addMonth();

            $financial->debit = $totalRate;
          
            $financial->save();
        }
    }
}


