<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function store(Request $request){
      $name = $request->name;
      $branch = $request->branch_id;
      $product = $request->$products;


      // $order = new Order();
      // $order->sendNotifyOrders($name,$amount,$branch);
      return response()->json([
        'message' => 'success',
        'data' => $request->all()
      ]);
      // event(new App\Events\Order($name,$amount,$branch));
    }
}
