<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function sendNotifyOrders($name,$amount,$branch){
      return event(new Events\Order($name,$amount,$branch));
    }

    public function orderProducts(){
      return $this->hasMany(OrderProduct::class, 'order_id','id');
    }

    public function branch(){
      return $this->belongsTo(branch::class, 'branch_id','id');
    }

    public function productCreated(){
      return $this->created_at->diffForHumans();
    }

    public function productUpdated(){
      return $this->updated_at->diffForHumans();
    }
}
