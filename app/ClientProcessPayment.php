<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientProcessPayment extends Model
{
    protected $guarded = [];
    protected $dates = ['payed_at'];

    public function clientProcess()
    {
        return $this->belongsTo(ClientProcess::class);
    }
}
