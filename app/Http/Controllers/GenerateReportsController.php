<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Occupant;
use App\Financial;
use App\User;
use DataTables;

class GenerateReportsController extends Controller
{


    public function monthly()
    {
      return view('admin.reports.monthly');
    }

    public function mReportsDatatable(Request $request)
    {
        if($request->get('filter') == 0)
        {
           $monthly = \DB::table('occupants')
                ->select('users.firstname','users.lastname', \DB::raw('SUM(credit) as total_credit'))
                ->join('financials','occupants.id', '=', 'financials.occupant_id')
                ->join('users','users.id', '=', 'occupants.user_id')
                ->join('rooms','rooms.id', '=', 'occupants.room_id')
                ->groupBy('users.firstname','users.lastname')
                ->whereYear('financials.created_at','=', $request->get('year'))
                ->where('financials.status','Paid')
                ->get();
        }
        else if($request->get('filter') == 1)
        {
           $monthly = \DB::table('occupants')
                ->select('users.firstname','users.lastname', \DB::raw('SUM(credit) as total_credit'))
                ->join('financials','occupants.id', '=', 'financials.occupant_id')
                ->join('users','users.id', '=', 'occupants.user_id')
                ->join('rooms','rooms.id', '=', 'occupants.room_id')
                ->groupBy('users.firstname','users.lastname')
                ->whereMonth('financials.created_at','=', $request->get('month'))
                ->where('financials.status','Paid')
                ->get();
        }
        else if($request->get('filter') == 2)
        {
           $monthly = \DB::table('occupants')
                ->select('users.firstname','users.lastname', \DB::raw('SUM(credit) as total_credit'))
                ->join('financials','occupants.id', '=', 'financials.occupant_id')
                ->join('users','users.id', '=', 'occupants.user_id')
                ->join('rooms','rooms.id', '=', 'occupants.room_id')
                ->groupBy('users.firstname','users.lastname')
                ->whereMonth('financials.created_at','=', $request->get('month'))
                ->whereYear('financials.created_at','=', $request->get('year'))
                ->where('financials.status','Paid')
                ->get();
        }
        else
        {
          // $today = \Carbon\Carbon::now();

          // $month = $today->month;

          // $year = $today->year;

          // $monthly = \DB::table('occupants')
          //       ->select('users.firstname','users.lastname', \DB::raw('SUM(credit) as total_credit'))
          //       ->join('financials','occupants.id', '=', 'financials.occupant_id')
          //       ->join('users','users.id', '=', 'occupants.user_id')
          //       ->join('rooms','rooms.id', '=', 'occupants.room_id')
          //       ->groupBy('users.firstname','users.lastname')
          //       ->whereMonth('financials.created_at','=', $month)
          //       ->whereYear('financials.created_at','=', $year)
          //       ->get();
        }

        // $today = \Carbon\Carbon::now();

        //   $month = $today->month;

        //   $year = $today->year;

       // $monthly = \DB::table('occupants')
       //          ->select('users.firstname','users.lastname',\DB::raw('count(amen_name)'),\DB::raw('count(amenities.id) as amenit')
       //          ->join('users','users.id', '=', 'occupants.user_id')
       //          ->join('amenities','amenities.id', '=', 'occupants.amenities_id')
       //          ->join('rooms','rooms.id', '=', 'occupants.room_id')
       //          ->groupBy('users.firstname','users.lastname')
       //          ->where('occupants.flag','=', 1)
       //          ->where('occupants.amenities_id' ,'=', null)
       //          ->whereMonth('occupants.created_at','=', $month)
       //          ->whereYear('occupants.created_at','=', $year)
       //          ->get();   

       return Datatables::of($monthly)
       ->make(true);
    }

    public function occupancy()
    {
      return view('admin.reports.occupancy');
    }

    public function cReportsDatatable(Request $request)
    {
      
     // if($request->get('filter') == 0)
     //  {
     //    $occupants = \DB::table('occupants')
     //    ->select('occupants.id','users.firstname','users.lastname','rooms.room_no','amenities.amen_name')
     //    ->join('users','users.id', '=', 'occupants.user_id')
     //    ->join('rooms','rooms.id', '=', 'occupants.room_id')
     //    ->leftjoin('amenities','amenities.id', '=', 'occupants.amenities_id')
     //    ->orderBy('occupants.id')
     //    ->whereYear('occupants.created_at','=', $request->get('year'))
     //    ->get();
     //  }
     //  else if($request->get('filter') == 1)
     //  {
     //      $occupants = \DB::table('occupants')
     //    ->select('occupants.id','users.firstname','users.lastname','rooms.room_no','amenities.amen_name')
     //    ->join('users','users.id', '=', 'occupants.user_id')
     //    ->join('rooms','rooms.id', '=', 'occupants.room_id')
     //    ->leftjoin('amenities','amenities.id', '=', 'occupants.amenities_id')
     //    ->orderBy('occupants.id')
     //    ->whereMonth('occupants.created_at','=', $request->get('month'))
     //    ->get();
     //  }
     //  else if($request->get('filter') == 2)
     //  {
     //      $occupants = \DB::table('occupants')
     //    ->select('occupants.id','users.firstname','users.lastname','rooms.room_no','amenities.amen_name')
     //    ->join('users','users.id', '=', 'occupants.user_id')
     //    ->join('rooms','rooms.id', '=', 'occupants.room_id')
     //    ->leftjoin('amenities','amenities.id', '=', 'occupants.amenities_id')
     //    ->orderBy('occupants.id')
     //    ->whereYear('occupants.created_at','=', $request->get('year'))
     //    ->whereMonth('occupants.created_at','=', $request->get('month'))
     //    ->get();
     //  }
     //  else
     //  {

     //  }

      // $today = \Carbon\Carbon::now();

      // $month = $today->month;

      // $occupants = Occupant::where('flag',1)->whereMonth('created_at',$month)->get();

      if($request->get('filter') == 0)
      {
        $occupants = Occupant::whereYear('start_date',$request->get('year'));
      }
      else if($request->get('filter') == 1)
      {
         $occupants = Occupant::whereMonth('start_date',$request->get('month'));
      }
      else if($request->get('filter') == 2) 
      {
        $occupants = Occupant::whereMonth('start_date',$request->get('month'))->whereYear('start_date',$request->get('year'));
      }
      else
      {
        $today = \Carbon\Carbon::now();

        $todayF = $today->toDateString();

        $occupants = Occupant::whereMonth('start_date','<',$todayF);
      }

      return Datatables::of($occupants)
      ->addColumn('name', function($occupant)
      {
          return $occupant->user->full_name; 
      })
      ->addColumn('roomNo', function($occupant)
      {
          return $occupant->room->room_no; 
      })
      ->addColumn('roomType', function($occupant)
      {
          return $occupant->room->type; 
      })
      ->addColumn('amenities', function($occupant)
      {
          $getName = [];

          foreach ($occupant->amenities as $amen)
          {
              $getName[] = $amen->amen_name;
          }
          return $getName;
          
      })
      ->make(true);
    }    
}
