<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Reservation;
use App\Financial;
use App\Room;
use App\Occupant;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Session;
use App\Amenities;

class ProcessBillingController extends Controller
{
    public function index()
    {
    	$occupants = Occupant::where('flag',1)->get();

    	return view('admin.process-billing-payment.index',compact('occupants'));
    }

    public function getProcessDatatable()
    {

        $financials = Financial::all();

        return Datatables::of($financials)
        ->addColumn('occupant', function($financial){
            return $financial->occupant->user->full_name;
        })
        ->addColumn('balance', function($financial){
            return $financial->balance();
        })
        ->addColumn('datepaid', function($financial){

            $format = \Carbon\Carbon::parse($financial->created_at);

            $formated = $format->toFormattedDateString();

            return $formated;
        })                                                                  
        ->addColumn('monthPayment', function($financial){


            $format = \Carbon\Carbon::parse($financial->payment_for);

            $formated = $format->toFormattedDateString();

            return $formated;
        })
        ->make(true);   
    }

    public function tenant_payments(Request $request)
    {
        if($request->occupant_id == 0)
        {
            Session::flash('validate','Please choose a Tenant');
             return redirect('/process/billing'); 
        }
        else
        {
              $occupants = Occupant::where('flag',1)->get();

               $financial = Occupant::find($request->occupant_id)->financials->sum('credit');

               $financial2 = Occupant::find($request->occupant_id)->financials->sum('debit');

               $balance = $financial - $financial2;

               $financials = Occupant::find($request->occupant_id)->financials;

               $occupant = Occupant::find($request->occupant_id);

               $occupantA = Occupant::find($request->occupant_id)->amenities()->sum('rate');

               $occuAvail = Occupant::find($request->occupant_id)->amenities()->get();
               

                return view('admin.process-billing-payment.tenant_payments',compact('occupants','financials','financial','balance','occupant','occupantA','occuAvail'));   
        }
    }

    public function payTenant(Request $request, $id)
    {
        if($request->ammount == '')
        {
            return response()->json(['success' => false, 'msg' => 'Enter amount']);
        }

        if($request->ammount <= 0 )
        {
            return response()->json(['success' => false, 'msg' => 'Invalid input']);
        }

        $getlatest = Financial::with('occupant')->where('occupant_id',$id)->orderBy('id','desc')->first();

        ///changes
        $financial = Occupant::find($id)->financials;

        if(count($financial) > 0)
        {
            foreach ($financial as $financia) 
            {
                $total = $financia->totalBalance();     
            }

            if($total == 0)
            {
                return response()->json(['success' => false, 'msg' => 'No balance']);
            }
            else
            {
                $financial = new Financial;
                
                $financial->credit = $request->ammount; 
                
                $financial->payment_for = $request->payment_for;

                $financial->status = 'Paid';

                $financial->remarks = $request->remarks;

                $financial->occupant_id = $id;

                $financial->save();

                if($financial->save())
                {
                  return response()->json(['success' => true, 'msg' => 'Successfully paid']);  
                }
                else
                {
                  return response()->json(['success' => false, 'msg' => 'An error occured while paying']);   
                }
            }
        }
        else
        {
            $financial = new Financial;
                
            $financial->credit = $request->ammount; 
            
            $financial->payment_for = $request->payment_for;

            $financial->status = 'Paid';

            $financial->remarks = $request->remarks;

            $financial->occupant_id = $id;

            $financial->save();

            if($financial->save())
            {
              return response()->json(['success' => true, 'msg' => 'Successfully paid']);  
            }
            else
            {
              return response()->json(['success' => false, 'msg' => 'An error occured while paying']);   
            }
        }
    }
}     

