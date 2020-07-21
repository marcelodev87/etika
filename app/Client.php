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

    public function processes()
    {
        return $this->hasMany(ClientProcess::class);
    }

    public function tasks()
    {
        return $this->hasMany(ClientTask::class);
    }
}
