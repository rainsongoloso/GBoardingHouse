<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $dates = ['created_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 
        'lastname',
        'dob',
        'email',
        'contact_no',
        'username',
        'password',
        'status',
        'role',
        'street_ad',
        'city',
        'province',
        'email_token',
        'verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reservation()
    {
        return $this->hasMany('App\Reservation');
    }
    
    public function occupant()
    {
        return $this->hasOne('App\Occupant');
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function address()
    {
        return $this->street_ad . ', ' . $this->city . ', ' . $this->province;
    }

    public function dob()
    {
        $getDob = $this->dob;

        $toBe = \Carbon\Carbon::parse($getDob);

        $formated = $toBe->toFormattedDateString();

        return $formated;
    }

    // public function getStreetAddressAttribute()
    // {
    //     return "{$this->street_ad} {$this->city} {$this->province}";
    // }
   

    /*public function isAdmin()
    {
        if($this->role->role_name == 'Admin')
        {
            return true;
        }
        return false;
    }

    public function isTenant()
    {
        if($this->role->role_name == 'Tenant')
        {
            return true;
        }
        return false;
    }*/  
}
