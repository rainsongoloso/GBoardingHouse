<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Reservation extends Model
{
    // public $timestamps = false;
    protected $dates = ['created_at'];

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }

    public function room()
    {
    	return $this->belongsTo('App\Room','room_id');
    }

    public function amenity()
    {
    	return $this->belongsTo('App\Amenities','amenities_id');		
    }

    public function formatdate()
    {
        $format =Carbon::parse($this->start_date);

        $formated = $format->toFormattedDateString();

        return $formated;
    }


}
