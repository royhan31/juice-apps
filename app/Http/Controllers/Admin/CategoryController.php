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
      $this->middleware('auth:api')->except('index');
  }

  public function index(){
    $categories = Category::orderBy('name', 'ASC')->get();
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

    $name = $request->name;
    $slug = str_slug($name);
    $error = ['name' => [ 'Kategori '.$name.' sudah ada.' ]];

    $categorySlug = Category::where('slug', $slug)->first();

    if($categorySlug){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    Category::create(['name' => $name,'slug' => $slug]);

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

    $name = $request->name;
    $slug = str_slug($name);
    $error = ['name' => [ 'Kategori '.$name.' sudah ada.']];

    $categorySlug = Category::where('slug', $slug)->first();

    if($slug == $category->slug){
      return response()->json(['message' => 'success','status' => true]);
    }
    elseif($categorySlug){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    $category->update(['name' => $name,'slug' => $slug]);

    return response()->json(['message' => 'success','status' => true]);
  }

  public function destroy(Category $category){
    $product = Product::where('category_id', $category)->first();
    $error = ['category' => [ 'Kategori '.$category->name.' sedang digunakan.']];

    if($product){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    $category->delete();
    return response()->json(['message' => 'success','status' => true]);
  }
}
