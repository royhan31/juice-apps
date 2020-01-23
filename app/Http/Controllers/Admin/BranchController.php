<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Branch;
use App\Order;

class BranchController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:api')->except('index');
  }

  public function index(){
    $branches = Branch::orderBy('name', 'ASC')->get();
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $branches
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
    $description = $request->description;

    $error = ['name' => [ 'Cabang '.$name.' sudah ada.' ]];

    $branchSlug = Branch::where('slug', $slug)->first();

    if($branchSlug){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    Category::create(['name' => $name,'slug' => $slug,'description' => $description]);

    return response()->json(['message' => 'success','status' => true,]);
  }

  public function update(Request $request, Branch $branch){
    $rule = [ 'name' => 'required|min:3|max:30' ];
    $message = [
      'required' => 'Isi bidang ini.',
      'min' => 'Nama kategori minimal 3 huruf.',
      'max' => 'Nama kategori maksimal 30 huruf.'
    ];

    $this->validate($request, $rule, $message);

    $name = $request->name;
    $slug = str_slug($name);
    $description = $request->description;

    $error = ['name' => [ 'Cabang '.$name.' sudah ada.']];

    $branchSlug = Branch::where('slug', $slug)->first();

    if($slug == $branch->slug){
      return response()->json(['message' => 'success','status' => true]);
    }
    elseif($branchSlug){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    $branch->update(['name' => $name,'slug' => $slug,'description' => $description]);

    return response()->json(['message' => 'success','status' => true]);
  }

  public function destroy(Branch $branch){
    $order = Order::where('branch_id', $branch)->first();
    $error = ['branch' => [ 'Cabang '.$branch->name.' sedang digunakan.']];

    if($order){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => $error
      ]);
    }

    $branch->delete();
    return response()->json(['message' => 'success','status' => true]);
  }
}
