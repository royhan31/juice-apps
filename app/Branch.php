<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function orders(){
      return $this->hasMany(Order::class, 'branch_id','id');
    }
}
