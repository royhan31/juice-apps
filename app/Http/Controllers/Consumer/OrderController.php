<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function store(Request $request){
      $orderProduct = json_decode(json_encode($request->all()),true);

      $order = new Order();
      $order->sendNotifyOrders($orderProduct);

      $data = (object) [];
      return response()->json([
        'message' => 'success',
        'status' => true,
        'data' => $data
      ], 201);
    }
}
