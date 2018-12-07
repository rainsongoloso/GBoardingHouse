<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Occupant extends Model
{
	protected $fillable = ['user_id','room_id','amenities_id','end_date'];
	
	public function amenity()
	{
		return $this->belongsTo('App\Amenities','amenities_id');
	}
	
	public function user()		
	{
		return $this->belongsTo(User::class);
	}

	public function room()
	{
		return $this->belongsTo(Room::class);
	}

	public function financials()
	{
		return $this->hasMany('App\Financial','occupant_id');
	}

	public function isNull()
	{
		if($this->amenities_id == NULL)
        {
            return false;
        }
        else
        {
            return true;  
        }
	}

	public function formatCreated()
	{
		$format = $this->created_at;

		$getToBe = \Carbon\Carbon::parse($format);

		$formated = $getToBe->toFormattedDateString();

		return $formated;
	}

	public function sumUp()
	{
		return $this->financials->credit->sum();
	}

	public function amenities()
	{
		return $this->belongsToMany('App\Amenities','occupant_amenities','occupant_id','amenities_id');
	}
}
