<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
  // public function __construct()
  // {
  //     $this->middleware('auth:api')->except('index');
  // }

  public function index(){
      $orders = Order::orderBy('id','DESC')->get();
      $results = [];
      foreach ($orders as $order) {
        $products = [];
        foreach ($order->products as $p) {
          $topings = [];
          foreach ($p->topingOrders as $t) {
            $topings[] = [
              'name' => $t->toping->name,
              'price' => $t->price
            ];
          }
         $products[] = [
             'name' => $p->product->name,
             'price' => $p->price,
             'topings' => $topings
          ];
        }
        $results[] = [
            'id' => $order->id,
            'name' => $order->name,
            'branch' => $order->branch->name,
            'created_at' => $order->created_at,
            'products' => $products
        ];
      }
      return response()->json([
        'message' => 'success',
        'status' => true,
        'data' => $results
      ]);
  }

  public function show($id){
    $order = Order::where('id', $id)->frist();
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $order
    ]);
  }


  public function showByBranch($id){
    $orders = Order::where('branch_id', $id)->get();
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $orders
    ]);
  }

  public function showByDate($date){
    //format year-month-day
    $orders = Order::whereDate('created_at', $date)->get();
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $orders
    ]);
  }
}
