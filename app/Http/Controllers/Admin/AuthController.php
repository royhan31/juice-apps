<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class AuthController extends Controller
{
    public function login(Request $request){
      $credential = [
        'username' => $request->username,
        'password' => $request->password
      ];

      if(!Auth::attempt($credential, $request->member)){
        return response()->json([
          'message' => 'login failed',
          'status' => false
        ]);
      }

      $user = User::find(Auth::user()->id);
      return response()->json([
        'message' => 'login success',
        'status' => true,
        'data' => $user
      ]);
    }
}
