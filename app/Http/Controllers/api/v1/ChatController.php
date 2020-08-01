<?php

namespace App\Http\Controllers\api\v1;

use App\Chat;
use App\Contact;
use App\Events\NewChat;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     *
     * @return \Illuminate\Http\JsonResponse with all user chats with first message of each chat
     *
     */
    public function index()
    {
        $user = Auth::user();
        $chats = $user->chats;
        return response()->json($chats, 200);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Add to Contacts Contacts
        $user1 =User::find(Auth::id());
        $user2= User::find($request->user_id);
        $user1->addFriend($user2);
        $user2->addFriend($user1);

        // Creating New Chat
        $chat = new Chat();
        $chat->save();
        $chat->users()->attach(User::find(Auth::id()));
        $chat->users()->attach(User::find($request->user_id));

        //Creating The First Message
        $message = new Message();
        $message->user_id = Auth::id();
        $message->body = $request->message;
        $message->chat_id = $chat->id;
        $message->save();

        $chat = $chat->load(['messages', 'users']);
        broadcast(new NewChat($chat, $request->user_id))->toOthers();
        return response()->json($chat, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $chat = Chat::find($id)->first();
        return response()->json($chat->load(['messages', 'users']), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $chat_id
//     * @return
     */
    public function update($user_id, $chat_id)
    {
        $chat = Chat::find($chat_id);

            User::where("id", $user_id)
                ->first()
                ->chats()
                ->attach($chat);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Chat::destroy($id);
        return response()->json(['message' => "hi from the other side"], 200);
    }
}
