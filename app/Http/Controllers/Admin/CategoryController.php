<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:api')->except(['index', 'search']);
  }

  public function index(){
    $categories = Category::orderBy('name', 'ASC')->get();
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $categories
    ]);
  }

  public function show(Category $category){
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $category
    ]);
  }

  public function search($keyword){
    $categories = Category::where('name','ILIKE','%'.$keyword.'%')->get(); //postgre
    // $categories = Category::where('name','ILIKE','%'.$keyword.'%')->get(); //mysql
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $categories
    ]);
  }

  public function store(Request $request){
    $rule = [ 'name' => 'required|min:3|max:30'];
    $message = [
      'required' => 'Isi bidang ini.',
      'min' => 'Nama kategori minimal 3 huruf.',
      'max' => 'Nama kategori maksimal 30 huruf.'
    ];
    $this->validate($request, $rule, $message);

    $name = ucwords(strtolower($request->name));
    $categoryName = Category::where('name', $name)->first();

    if($categoryName){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => 'Nama Kategori '.$name.' sudah ada.'
      ]);
    }

    Category::create(['name' => $name]);

    return response()->json(['message' => 'success','status' => true,]);
  }

  public function update(Request $request, Category $category){
    $rule = [ 'name' => 'required|min:3|max:30'];
    $message = [
      'required' => 'Isi bidang ini.',
      'min' => 'Nama kategori minimal 3 huruf.',
      'max' => 'Nama kategori maksimal 30 huruf.'
    ];
    $this->validate($request, $rule, $message);

    $name = ucwords(strtolower($request->name));
    $categoryName = Category::where('name', $name)->first();

    if($name == $category->name){
      return response()->json(['message' => 'success','status' => true]);
    }elseif($categoryName){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => 'Nama Kategori '.$name.' sudah ada.'
      ]);
    }

    $category->update(['name' => $name]);

    return response()->json(['message' => 'success','status' => true]);
  }

  public function destroy(Category $category){
    $product = Product::where('category_id', $category->id)->first();

    if($product){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => 'Kategori '.$category->name.' sedang digunakan.'
      ]);
    }

    $category->delete();
    return response()->json(['message' => 'success','status' => true]);
  }
}
