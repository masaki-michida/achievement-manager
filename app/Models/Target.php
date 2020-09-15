<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{

  protected $fillable = ['title','archievement','confirmation','complete','detail','user_id'];

  public function user()
  {
      return $this->belongsTo('App\Models\User');
  }
  public function goals()
  {
      return $this->hasMany('App\Models\Goal');
  }
}
