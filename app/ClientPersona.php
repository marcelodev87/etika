<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPersona extends Model
{
    protected $guarded = [];


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
}
