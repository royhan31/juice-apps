<?php

namespace App\Http\Controllers\Cashier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrderController extends Controller
{
    public function index($branch){
      $orders = Order::where('branch_id', $branch)->where('status',true)->get();

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
        'data' => $orders
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
