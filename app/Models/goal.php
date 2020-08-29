<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{

    protected $fillable = ['title',' archievement','detail','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
