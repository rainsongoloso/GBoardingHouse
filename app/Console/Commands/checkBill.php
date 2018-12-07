<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reservation;
use Carbon\Carbon;
use App\Financial;
use App\Occupant;
use Session;

class checkBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkBill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check bills every month';

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
        $today = \Carbon\Carbon::now();

        $format = $today->toDateString(); 

        // $ocF = Occupant::with('financials')
        // ->where('flag',1)
        // ->whereHas('financials', function($query) use ($format)
        // {
        //     $query->where('payment_for', $format);
        // })
        // ->get();
        
        $ocF = Occupant::where('flag',1)->where('start_date',$format)->get();

        foreach ($ocF as $oc) {

            $occupant = Occupant::find($oc->id);
        
            $rRoom = $occupant->room->roomRate();

            $getRates = 0;
            
            foreach ($occupant->amenities as $amen)
            {
                $getRates += $amen->rate; 
            }

            $totalRate = $rRoom + $getRates;

            $financial = new Financial;

            $financial->occupant_id = $oc->id;

            $financial->status = 'Unpaid';

            $financial->remarks = 'Rent';

            $thisMonth = \Carbon\Carbon::now();
            // $addMonth->addMonth();

            $financial->payment_for = $thisMonth;

            $financial->debit = $totalRate;
          
            $financial->save();       
        }

        Session::flash('message','New financial record added');
    }
}
