<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Branch;
use App\Order;
use App\Category;

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

    public function productCreate(){
      $categories = Category::orderBy('name', 'ASC')->get();
      // dd($categories);
      return view('home.product.create', compact('categories'));
    }

    public function productEdit($id){
      $categories = Category::orderBy('name', 'ASC')->get();
      $product = Product::find($id);
      return view('home.product.edit', compact('categories', 'product'));
    }

    public function toping(){
      $categories = Category::orderBy('name', 'ASC')->get();
      return view('home.toping', compact('categories'));
    }

    public function branch(){return view('home.branch');}

}
