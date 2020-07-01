<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function MongoDB\BSON\toJSON;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        // checking if avatar is set

        if ($img = $request->file('avatar')) {
            $filename = time() . "_" . $img->getClientOriginalName();
            $filename = str_replace(' ', '-', $filename);
            if (!($img->storeAs('public/avatars', $filename))) {
                return response()->json(["message" => "Internal Server Error!"], 500);
            }
        } else {
            $filename = 'no-avatar.jpeg';
        }

        // Adding new User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->avatar = $filename;
        if (!$user->save()) {
            return response()->json([
                'message' => 'Server Error! Try Again Later',
            ], 500);
        } else {
            return response()->json([
                'message' => 'You were successfully registered!',
            ], 200);
        }
    }
}
