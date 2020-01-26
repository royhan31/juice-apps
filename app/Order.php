<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function sendNotifyOrders($name,$amount,$branch){
      return event(new Events\Order($name,$amount,$branch));
    }
}
