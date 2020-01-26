<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Storage;

class ProductController extends Controller
{
  // public function __construct()
  // {
  //     $this->middleware('auth:api')->except('index');
  // }

  public function index(){
    $results = [];
    $products = Product::all();

    foreach ($products as $p) {
      $results[] = [
          'id' => $p->id,
          'name' => $p->name,
          'category' => $p->category->name,
          'price' => $p->price,
          'image' => $p->image,
          'description' => $p->description,
      ];
    }

    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $results
    ]);
  }

  public function store(Request $request){
    $rule = [
      'name' => 'required|min:3|max:100',
      'price' => 'required',
      'description' => 'required',
      'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
      'category_id' => 'required'
    ];
    $message = [
      'required' => 'Isi bidang ini.',
      'min' => 'Nama minimal 3 huruf.',
      'max' => 'Nama maksimal 100 huruf.',
      'mimes' => 'Masukan gambar JPEG,JPG,PNG',
    ];
    $this->validate($request, $rule, $message);

    $name = $request->name;
    $slug = str_slug($name);
    $error = ['name' => [$name.' sudah ada.' ]];

    $productSlug = Product::where('slug', $slug)->first();

    if($productSlug){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    $image = $request->file('image')->store('images');
    Product::create([
      'name' => $name,
      'slug' => $slug,
      'category_id' => $request->category_id,
      'price' => $request->price,
      'description' => $request->description,
      'image' => $image
    ]);

    return response()->json([
      'message' => 'success',
      'status' => true,
    ]);
  }


  public function show(Product $product){
    $product = [
      'id' => $p->id,
      'name' => $p->name,
      'category' => $p->category->name,
      'price' => $p->price,
      'image' => $p->image,
      'description' => $p->description,
      'created_at' => $p->productCreated(),
      'updated_at' => $p->productUpdated(),
    ];
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $product
    ]);
  }
}
