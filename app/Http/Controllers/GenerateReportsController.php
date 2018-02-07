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
      // $occupants = \DB::table('occupants')
      //           ->select('users.firstname','users.lastname', \DB::raw('SUM(credit) as total_credit'))
      //           ->join('financials','occupants.id', '=', 'financials.occupant_id')
      //           ->join('users','users.id', '=', 'occupants.user_id')
      //           ->join('rooms','rooms.id', '=', 'occupants.room_id')
      //           ->groupBy('users.firstname','users.lastname')
      //           ->whereMonth('financials.created_at','=', $request->get('month'))
      //           ->whereYear('financials.created_at','=', $request->get('year'))
      //           ->get();

     // $occupants = Occupant::with('financials')->where('flag',1);

      
      
      // ->addColumn('user', function($occupant){
      //     return $occupant->user->full_name;
      // })
      // ->addColumn('room', function($occupant){
      //     return $occupant->room->room_no;
      // })
      // ->addColumn('amenity', function($occupant){
      //   if($occupant->isNull())
      //   {
      //     return $occupant->amenity->amen_name;
      //   }
      //   else
      //   {
      //     return 'None';
      //   }
      // })
      // ->addColumn('financial', function($occupant){

      //    $occ = $occupant->financials;

      //    $total = 0;

      //    foreach ($occ as $oc) 
      //    {
      //      $total += $oc->credit;
      //    } 

      //    return $total;
      // })
      
    }

    public function occupancy()
    {
      $occupant = Occupant::where('flag',1)->count();

      return view('admin.reports.occupancy',compact('occupant'));
    }

    public function cReportsDatatable(Request $request)
    {
      
     if($request->get('filter') == 0)
      {
        $occupants = \DB::table('occupants')
        ->select('occupants.id','users.firstname','users.lastname','rooms.room_no','amenities.amen_name')
        ->join('users','users.id', '=', 'occupants.user_id')
        ->join('rooms','rooms.id', '=', 'occupants.room_id')
        ->join('amenities','amenities.id', '=', 'occupants.amenities_id')
        ->orderBy('occupants.id')
        ->whereYear('occupants.created_at','=', $request->get('year'))
        ->get();
      }
      else if($request->get('filter') == 1)
      {
          $occupants = \DB::table('occupants')
        ->select('occupants.id','users.firstname','users.lastname','rooms.room_no','amenities.amen_name')
        ->join('users','users.id', '=', 'occupants.user_id')
        ->join('rooms','rooms.id', '=', 'occupants.room_id')
        ->join('amenities','amenities.id', '=', 'occupants.amenities_id')
        ->orderBy('occupants.id')
        ->whereMonth('occupants.created_at','=', $request->get('month'))
        ->get();
      }
      else if($request->get('filter') == 2)
      {
          $occupants = \DB::table('occupants')
        ->select('occupants.id','users.firstname','users.lastname','rooms.room_no','amenities.amen_name')
        ->join('users','users.id', '=', 'occupants.user_id')
        ->join('rooms','rooms.id', '=', 'occupants.room_id')
        ->join('amenities','amenities.id', '=', 'occupants.amenities_id')
        ->orderBy('occupants.id')
        ->whereYear('occupants.created_at','=', $request->get('year'))
        ->whereMonth('occupants.created_at','=', $request->get('month'))
        ->get();
      }
      else
      {

      }

      // $today = \Carbon\Carbon::now();

      // $month = $today->month;

      // $occupants = Occupant::where('flag',1)->whereMonth('created_at',$month)->get();

      return Datatables::of($occupants)
      // ->addColumn('user', function($occupant){
      //     return $occupant->user->full_name;
      // })
      // ->addColumn('room', function($occupant){
      //     return $occupant->room->room_no;
      // })
      // ->addColumn('amenity', function($occupant){
      //   if($occupant->isNull())
      //   {
      //     return $occupant->amenity->amen_name;
      //   }
      //   else
      //   {
      //     return 'None';
      //   }
      // })
      // ->addColumn('dateStart', function($occupant){
      //     if($occupant->user->reservation == !null)
      //     {
      //       $format = \Carbon\Carbon::parse($occupant->user->reservation->start_date);

      //       $formated = $format->toFormattedDateString();

      //       return $formated;
      //     }
      //     else
      //     {
      //       $format = \Carbon\Carbon::parse($occupant->created_at);

      //       $formated = $format->toFormattedDateString();

      //       return $formated;
      //     }
      // })
      // ->addColumn('monthly', function($occupant){
      //     if($occupant->isNull())
      //     {

      //       return number_format($occupant->room->roomRate() + $occupant->amenity->rate, 2, '.', ',');
      //     }
      //     else
      //     {
      //       return number_format($occupant->room->roomRate(), 2, ',', '.');
      //     }
      // })
      // ->addColumn('rType', function($occupant){
      //     return $occupant->room->type;
      // })
      ->make(true);
    }    
}
