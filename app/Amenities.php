<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'rate', 'description','amen_name',
    ];

    public function occupants()
    {
    	return $this->belongsToMany('App\Occupant','occupant_amenities','amenities_id','occupant_id');
    } 

    public function reservation()
    {
    	return $this->hasMany('App\Amenities');
    }
}
