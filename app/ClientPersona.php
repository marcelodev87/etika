<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPersona extends Model
{
    protected $guarded = [];
    protected $dates =['dob'];


    public function client()
    {
        return $this->belongTo(Client::class);
    }

    public function addresses()
    {
        return $this->hasMany(ClientPersonaAddress::class);
    }

    public function emails()
    {
        return $this->hasMany(ClientPersonaEmail::class);
    }

    public function phones()
    {
        return $this->hasMany(ClientPersonaPhone::class);
    }
    public function fullAddress()
    {
        $address = $this->addresses()->where('main', 1)->first();
        $a = $address->street;
        if ($address->street_number) {
            $a .= ', ' . $address->street_number;
        }
        if ($address->complement) {
            $a .= ' (' . $address->complement . ')';
        }

        $a .= ', ' . $address->city . ', ' . $address->neighborhood . ' - ' . $address->state . ' - ' . $address->zip;

        return $a;
    }
}
