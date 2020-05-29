<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
  public function login(Request $request) {

    $login = $request->validate([
      'email' => 'required|string',
      'password' => 'required|string',
    ]);
    if (!Auth::attempt($login)) {
      return response([
        'message' => 'Email or Password are not correct!',
        'status_code' => 401,
      ]);
    }

    $user = Auth::user();

    // Creating a token without scopes...
    $token = $user->createToken('authToken')->accessToken;
    $response = response(['user' => Auth::user(), 'access_token' => $token]);

    return $response;

  }

}
