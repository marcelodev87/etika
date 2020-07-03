<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    public function members()
    {
        return $this->hasMany(ClientPersona::class);
    }
}
