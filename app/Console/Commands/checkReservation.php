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
        $reservations = Reservation::where('status','Active')->get();

        foreach($reservations as $reservation)
        {
            if($reservation->created_at->diffInMonths(Carbon::now()) == 1)
            {
                $reservation->status = 'Cancel';

                $reservation->save();
            } 
        }
        
        Session::flash('message','Reservation has been canceled');
    }
}
