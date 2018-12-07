<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reservation;
use \Carbon\Carbon;
use Session;
class checkReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkReservation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check reservation every month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $getToday = \Carbon\Carbon::now();
        $lastweek = $getToday->subDays(7);
        $format = $lastweek->toDateString();
        $getYear = $lastweek->year;
        $getMonth = $lastweek->month;
        $getDay = $lastweek->day;
       
        $reservations = App\Reservation::where('status','=','Active')
        ->whereMonth('created_at','=',$getMonth)
        ->whereDay('created_at','=',$getDay)
        ->whereYear('created_at','=',$getYear)
        ->get();

        $reservationsId = App\Reservation::where('status','=','Active')
        ->whereMonth('created_at','=',$getMonth)
        ->whereDay('created_at','=',$getDay)
        ->whereYear('created_at','=',$getYear)
        ->pluck('id');

        foreach($reservations as $reservation)
        {
            $reservation->status = 'Cancel';
            $reservation->save();
        }
        
        Session::flash('message','Canceled Reservations'.$reservationsId);
    }
}
