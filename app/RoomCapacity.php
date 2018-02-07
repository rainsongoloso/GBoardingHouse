<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomCapacity extends Model
{
    //


    public static function availables(){
    	return self::where('user_id','==', null)->count();
    }
    public static function occupied(){
    	return self::where('user_id','!=', null)->count();
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
     public function room(){
    	return $this->belongsTo(Room::class);
    }



}
