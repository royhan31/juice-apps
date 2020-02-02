<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopingOrder extends Model
{
  public $incrementing = false;

  public $timestamps = false;

  protected $guarded = [];

  protected $hidden = ['order_product_id','toping_id'];

  public function productOrder(){
    return $this->belongsTo(ProductOrder::class, 'order_product_id','id');
  }

  public function toping(){
    return $this->belongsTo(Toping::class, 'toping_id','id');
  }
}
