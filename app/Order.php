<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function sendNotifyOrders($orderProduct, $branch){
      return event(new Events\Order($orderProduct, $branch));
    }

    public function products(){
      return $this->hasMany(ProductOrder::class, 'order_id','id');
    }

    public function branch(){
      return $this->belongsTo(Branch::class, 'branch_id','id');
    }

    public function productCreated(){
      return $this->created_at->diffForHumans();
    }

    public function productUpdated(){
      return $this->updated_at->diffForHumans();
    }
}
