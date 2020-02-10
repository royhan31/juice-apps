<?php

namespace App\Http\Controllers\Consumer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductController extends Controller
{
  public function index(){
    $results = [];
    $products = Product::where('status', true)->orderBy('id','DESC')->get();
    foreach ($products as $p) {$results[] = $p->products($p);}
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $results
    ]);
  }

  public function showByCategory($id){
    $results = [];
    $products = Product::where('status', true)->where('category_id', $id)->get();
    foreach ($products as $p) {$results[] = $p->products($p);}
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $results
    ]);
  }

  public function search(Request $request){
    $results = [];
    $products;
    if(config('app.env') === 'production') {
    $products = Product::where('status', true)->where('name','ILIKE','%'.$request->keyword.'%')
                ->orderBy('id','DESC')->get();
    }else{
    $products = Product::where('status', true)->where('name','LIKE','%'.$request->keyword.'%')
                  ->orderBy('id','DESC')->get();
    }
    $paginate = $this->productPaginate($products);
    foreach ($products as $p) {$results[] = $p->products($p);}
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $results,
      'paginate' => $paginate
    ]);
  }
}
