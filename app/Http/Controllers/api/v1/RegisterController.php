<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
  public function register(Request $request) {
    // TODO: Add Avatar validation and logic
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:20',
      'email' => 'required|string|unique:users',
      'password' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json([$validator->messages()], 403);
    }

    // Adding new User
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->avatar = null;
    if (!$user->save()) {
      return response()->json([
        'message' => 'Server Error! Try Again Later',
        'status_code' => 500,
      ], 500);
    } else {
      return response()->json([
        'message' => 'You were successfully registered!',
        'status_code' => 200,
      ], 200);
    }
  }
}
