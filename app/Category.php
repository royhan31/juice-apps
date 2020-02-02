<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function products(){
      return $this->hasMany(Product::class, 'category_id','id');
    }

    public function topings(){
      return $this->hasMany(Toping::class, 'Toping_id','id');
    }
}
