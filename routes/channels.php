<?php

use Illuminate\Support\Facades\Broadcast;
use App\Chat;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|p
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('chat.{id}', function ($user, $chatId) {
    $chat = Chat::find($chatId);

   if ($chat->users->contains($user)) {
        return $user;
    }
});
Broadcast::channel('newChat.{user_id}', function ($user, $user_id) {
    return $user->id == $user_id;
});
