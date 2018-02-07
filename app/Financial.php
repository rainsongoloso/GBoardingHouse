<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
	protected $dates = ['payment_for'];

    public function users()
    {
    	return $this->belongsTo('App\User','user_id');
    }

    public function occupant()
    {
    	return $this->belongsTo(Occupant::class);
    }

    public function payForFormat()
    {
    	$tobeFormat = $this->payment_for;
    	$formated = Carbon::parse($tobeFormat);
    	$payFor = $formated->toFormattedDateString();
    	return $payFor;
    }

    public function balance()
    {	
    	$balance = $this->credit - $this->debit;

    	return $balance;
    }

    public function formatCreated_at()
    {
        $format = Carbon::parse($this->created_at);

        $formated = $format->toFormattedDateString();

        return $formated;
    }

    public function income()
    {
        return $this->sum('credit');
    }

    public function totalBalance()
    {
        $credit = $this->sum('credit');

        $debit = $this->sum('debit');

        $tBalance = $credit - $debit;

        return $tBalance;
    }

    public function formatCredit()
    {
        $toBe = $this->credit;

        $formated = number_format($toBe, 2);

        return $formated;
    }

    public function formatDebit()
    {
        $toBe = $this->debit;

        $formated = number_format($toBe, 2);

        return $formated;
    }
}
