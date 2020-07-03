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
}
