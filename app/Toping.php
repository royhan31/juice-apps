<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toping extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function category(){
      return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function topingOrders(){
      return $this->hasMany(TopingOrder::class,'toping_id','id');
    }

    public function topings($toping){
      return [
            'id' => $toping->id,
            'name' => $toping->name,
            'category' => $toping->category->name,
            'price' => $toping->price
        ];
    }
}
