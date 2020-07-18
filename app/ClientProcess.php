<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientProcess extends Model
{
    protected $guarded = [];

    public function tasks()
    {
        return $this->hasMany(ClientProcessTask::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function process()
    {
        return $this->belongsTo(InternalProcess::class);
    }

    public function payments()
    {
        return $this->hasMany(ClientProcessPayment::class);
    }

    public function totalPrice()
    {
        $valorProcesso = $this->price;
        $valorExtra = $this->tasks()->sum('price');
        $valorTotal = $valorProcesso + $valorExtra;
        return $valorTotal;
    }

    public function totalPayed()
    {
        return $this->payments()->sum('value');
    }
}
