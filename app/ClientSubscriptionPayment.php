<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientSubscriptionPayment extends Model
{
    protected $guarded = [];
    protected $dates = ['pay_at'];
}
