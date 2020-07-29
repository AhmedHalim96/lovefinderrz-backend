<?php

namespace App\Http\Controllers\api\v1;

use App\Events\UserOnline;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserOnlineController extends Controller
{
    public function __invoke(User $user)
    {
        $user->status = 'online';
        $user->save();
        broadcast(new UserOnline($user));
    }
}
