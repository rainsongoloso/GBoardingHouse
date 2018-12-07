<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Room extends Model
{
    protected $fillable = [
        'room_no','status','type','current_capacity','max_capacity','rate','description','room_image'
    ];

    public function roomRate()
    {
      if($this->type == 'Bed Spacer')
      {
        return $this->rate / $this->max_capacity;
      }
      else
      {
        return $this->rate;
      }
    }

    public function occupants()
    {
      return $this->hasMany('App\Occupant');
    }

    public function reservations()
    {
      return $this->hasMany('App\Reservation');
    }
}
