<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserOfflineController extends Controller
{
    public function __invoke(User $user)
    {
        $user = User::find(\Auth::id());
        $user->status = 'offline';
        $user->save();
        broadcast(new UserOnline($user))->toOthers();
    }
}
