<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Branch;
use App\Order;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
      $products = Product::all();
      $orders = Order::all();
      $branches = Branch::all();
      return view('home.dashboard', compact('products','orders','branches'));
    }

    public function category(){return view('home.category');}

    public function product(){return view('home.product.product');}
}
