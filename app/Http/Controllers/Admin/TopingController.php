<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Toping;
use App\TopingOrder;

class TopingController extends Controller
{
  // public function __construct()
  // {
  //     $this->middleware('auth:api')->except('index');
  // }

  public function index(){
    $topings = Toping::orderBy('name', 'ASC')->get();
    $results = [];
    foreach ($topings as $toping) {$results[] = $toping->topings($toping);}
    return response()->json(['message' => 'success','status' => true,'data' => $results]);
  }

  public function showByCategory($id){
    $topings = Toping::where('category_id', $id)->orderBy('name', 'ASC')->get();
    $results = [];
    foreach ($topings as $toping) {$results[] = $toping->topings($toping);}
    return response()->json(['message' => 'success','status' => true,'data' => $results]);
  }

  public function store(Request $request){
    $rule = [
      'name' => 'required|min:3|max:30',
      'category' => 'required',
      'price' => 'required|digits:5',
    ];
    $message = [
      'required' => 'Isi bidang ini.',
      'min' => 'Nama kategori minimal 3 huruf.',
      'max' => 'Nama kategori maksimal 30 huruf.',
      'price.digits' => 'Harga minimal Rp. 100'
    ];
    $this->validate($request, $rule, $message);
    $name = $request->name;
    $category = $request->category;
    $price = $request->price;

    $name = ucwords(strtolower($request->name));
    $topingName = Toping::where('name', $name)->where('category_id',$category)->first();

    if($topingName){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => [
          'name' => [ 'Nama Toping '.$name.' dengan kategori '
          .$topingName->category->name.' sudah ada.']]
      ]);
    }

    Toping::create(['name' => $name, 'category_id' => $category, 'price' => $price ]);

    return response()->json(['message' => 'success','status' => true,]);
  }

  public function update(Request $request, Toping $toping){
    $rule = [
      'name' => 'required|min:3|max:30',
      'category' => 'required',
      'price' => 'required|digits:5',
    ];
    $message = [
      'required' => 'Isi bidang ini.',
      'min' => 'Nama kategori minimal 3 huruf.',
      'max' => 'Nama kategori maksimal 30 huruf.',
      'price.digits' => 'Harga minimal Rp. 100'
    ];
    $this->validate($request, $rule, $message);

    $name = $request->name;
    $category = $request->category;
    $price = $request->price;

    $checkName = ucfirst($name);

    $topingValidate = Toping::where('name', $checkName)
                  ->where('category_id',$category)
                  ->first();
   if($toping->name == $checkName && $toping->category_id == $category){
     $toping->update(['name' => $checkName, 'category_id' => $category, 'price' => $price]);
     return response()->json(['message' => 'success','status' => true]);
   }
   elseif($topingValidate){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => [
          'name' => [ 'Toping '.$topingValidate->name.' dengan kategori '
          .$topingValidate->category->name.' sudah ada.']]
      ]);
    }

    $toping->update(['name' => $checkName, 'category_id' => $category, 'price' => $price]);

    return response()->json(['message' => 'success','status' => true]);
  }

  public function destroy(Toping $toping){
    $topingOrder = TopingOrder::where('toping_id', $toping)->first();
    $error = ['toping' => [ 'Toping '.$toping->name.' sedang digunakan.']];

    if($topingOrder){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    $toping->delete();
    return response()->json(['message' => 'success','status' => true]);
  }
}
