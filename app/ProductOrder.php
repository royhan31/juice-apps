<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
  public $timestamps = false;

  protected $guarded = [];

  protected $hidden = ['product_id','order_id'];

  public function order(){
    return $this->belongsTo(Order::class, 'order_id','id');
  }

  public function topingOrders(){
    return $this->hasMany(TopingOrder::class,'product_order_id','id');
  }
}
