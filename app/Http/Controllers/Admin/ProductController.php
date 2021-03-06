<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Storage;

class ProductController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:api')->except(['index','showByCategory','search']);
  }

  public function productPaginate($products){
    return [
      'current_page' => $products->currentPage(),
      'last_page' => $products->lastPage(),
    ];
  }

  public function index(){
    $results = [];
    $products = Product::orderBy('id','DESC')->Paginate(4);
    $paginate = $this->productPaginate($products);
    foreach ($products as $p) {$results[] = $p->products($p);}
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $results,
      'paginate' => $paginate
    ]);
  }

  public function store(Request $request){
    $rule = [
      'name' => 'required|min:3|max:100',
      'price' => 'required',
      'description' => 'required',
      'image' => 'required|mimes:jpeg,jpg,png|max:2048',
      'category_id' => 'required'
    ];
    $message = [
      'required' => 'Isi bidang ini.',
      'name.min' => 'Nama minimal 3 huruf.',
      'name.max' => 'Nama maksimal 100 huruf.',
      'image.mimes' => 'Masukan gambar JPEG,JPG,PNG',
      'image.uploaded' => 'Gambar maksimal 2MB',
    ];
    $this->validate($request, $rule, $message);

    $name = ucwords(strtolower($request->name));
    $productName = Product::where('name', $name)->first();

    if($productName){
      $error = ['name' => [$name.' sudah ada.' ]];
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    $image = $request->file('image')->store('');
    Product::create([
      'name' => $name,
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

  public function update(Request $request, $id){
    $rule = [
      'name' => 'required|min:3|max:100',
      'price' => 'required',
      'description' => 'required',
      'image' => 'mimes:jpeg,jpg,png|max:2048',
      'category_id' => 'required',
      'status' => 'required'
    ];
    $message = [
      'required' => 'Isi bidang ini.',
      'name.min' => 'Nama minimal 3 huruf.',
      'name.max' => 'Nama maksimal 100 huruf.',
      'image.mimes' => 'Masukan gambar JPEG,JPG,PNG',
      'image.uploaded' => 'Gambar maksimal 2MB',
    ];
    $this->validate($request, $rule, $message);

    $name = ucwords(strtolower($request->name));
    $productName = Product::where('name', $name)->first();
    $product = Product::find($id);
    $image = $product->image;

    if($name == $product->name){
        if($request->image){
          $image_path = $image;
          if (Storage::exists($image_path)) {
            Storage::delete($image_path);
            }
          $image = $request->file('image')->store('');
        }
        $product->update([
          'name' => $name,
          'category_id' => $request->category_id,
          'price' => $request->price,
          'description' => $request->description,
          'image' => $image,
          'status' => $request->status
        ]);
        return response()->json([
          'message' => 'success',
          'status' => true,
        ]);
      }

    elseif($productName){
      $error = ['name' => [$name.' sudah ada.' ]];
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    if($request->image){
      $image_path = $image;
      if (Storage::exists($image_path)) {
        Storage::delete($image_path);
        }
      $image = $request->file('image')->store('');
    }
    $product->update([
      'name' => $name,
      'category_id' => $request->category_id,
      'price' => $request->price,
      'description' => $request->description,
      'image' => $image,
      'status' => $request->status
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

  public function showByCategory($id){
    $results = [];
    $products = Product::where('category_id', $id)->orderBy('id','DESC')->paginate(4);
    $paginate = $this->productPaginate($products);
    foreach ($products as $p) {$results[] = $p->products($p);}
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $results,
      'paginate' => $paginate
    ]);
  }

  public function search($keyword){
    $results = [];
    $products;
    if(config('app.env') === 'production') {
    $products = Product::where('name','ILIKE','%'.$keyword.'%')->orderBy('id','DESC')->Paginate(4);
    }else{
    $products = Product::where('name','LIKE','%'.$keyword.'%')->orderBy('id','DESC')->Paginate(4);
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
