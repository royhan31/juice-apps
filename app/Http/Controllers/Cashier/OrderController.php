<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\ProductOrder;
use App\TopingOrder;

class OrderController extends Controller
{
    public function index($branch){
      $orders = Order::all();

      return response()->json([
        'message' => 'success',
        'status' => true,
        'data' => $orders
      ]);
    }

    public function show($id){
      $order = Order::where('id', $id)->first();

      return response()->json([
        'message' => 'success',
        'status' => true,
        'data' => $order
      ]);
    }

    public function store(Request $request){
      $data = json_decode(json_encode($request->all()),true);
      $products = $data['products'];
      $topings = [];

      $order = Order::create(['branch_id' => $data['branch'],'name' => $data['name']]);
      for ($i=0; $i < count($products) ; $i++) {
          $product = ProductOrder::create([
            'order_id' => $order->id,
            'product_id' => $products[$i]['id'],
            'price' => $products[$i]['price']
          ]);
          $topings = $products[$i]['selectedToppings'];
          for ($j=0; $j < count($topings) ; $j++) {
            TopingOrder::create([
                'product_order_id' => $product->id,
                'toping_id' => $topings[$j]['id'],
                'price' => $topings[$j]['price']
              ]);
          }
      }
      //foreach($products as $p) {
        // $product = ProductOrder::create([
        //   'order_id' => $order->id,
        //   'product_id' => $p['id'],
        //   'price' => $p['price']
        // ]);
        //$topings = $p['selectedToppings'];
        // foreach ($topings as $t) {
        //   TopingOrder::create([
        //     'product_order_id' => $product->id,
        //     'toping_id' => $t['id'],
        //     'price' => $t['price']
        //   ]);
        // }
      //}

      return response()->json([
        'message' => 'success',
        'status' => true
      ]);


    }

    public function showStatus($status){
      $order = Order::where('status', $status)->get();
      return response()->json([
        'message' => 'success',
        'status' => true,
        'data' => $orders
      ]);
    }
}
