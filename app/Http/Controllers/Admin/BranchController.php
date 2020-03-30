<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Branch;
use App\Order;

class BranchController extends Controller
{
  // public function __construct()
  // {
  //     $this->middleware('auth:api')->except('index');
  // }

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

    $name = ucwords(strtolower($request->name));
    $description = $request->description;

    $branchName = Branch::where('name', $name)->first();

    if($branchName){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => 'Nama Cabang '.$name.' sudah ada.'
      ]);
    }

    Branch::create(['name' => $name,'description' => $description]);

    return response()->json(['message' => 'success','status' => true,]);
  }

  public function show($id){
    $branch = Branch::find($id);
    return response()->json([
      'message' => 'success',
      'status' => true,
      'data' => $branch
    ]);
  }

  public function update(Request $request, Branch $branch){
    $rule = [ 'name' => 'required|min:3|max:30' ];
    $message = [
      'required' => 'Isi bidang ini.',
      'min' => 'Nama kategori minimal 3 huruf.',
      'max' => 'Nama kategori maksimal 30 huruf.'
    ];
    $this->validate($request, $rule, $message);

    $name = ucwords(strtolower($request->name));
    $description = $request->description;

    $branchName = Branch::where('name', $name)->first();
    if($name == $branch->name){
     return response()->json(['message' => 'success','status' => true]);
    }
    elseif($branchName){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => 'Nama Cabang '.$name.' sudah ada.'
      ]);
    }

    $branch->update(['name' => $name,'description' => $description]);

    return response()->json(['message' => 'success','status' => true]);
  }

  public function destroy(Branch $branch){
    $order = Order::where('branch_id', $branch)->first();

    if($order){
      return response()->json([
        'message' => 'failed',
        'status' => false,
        'errors' => 'Cabang '.$branch->name.' sedang digunakan.'
      ]);
    }

    $branch->delete();
    return response()->json(['message' => 'success','status' => true]);
  }
}
