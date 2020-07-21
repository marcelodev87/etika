<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientProcessTask extends Model
{
    protected $guarded = [];

    protected $dates = ['end_at'];

    public function task()
    {
        return $this->belongsTo(InternalTask::class, 'task_id');
    }

    public function closedBy()
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function comments()
    {
        return $this->hasMany(ClientProcessTaskComment::class);
    }
}
