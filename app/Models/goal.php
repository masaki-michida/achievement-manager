<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{

    protected $fillable = ['title','target_id','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function target(){
        return $this->belongsTo('App\Models\Target');
    }
}
