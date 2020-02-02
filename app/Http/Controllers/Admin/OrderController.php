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
        $results[] = [
            'id' => $order->id,
            'name' => $order->name,
            'branch' => $order->name,
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
    $orders = Order::->whereDate('created_at', $date)->get();
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $orders
    ]);
  }
}
