<?php

namespace App\Http\Controllers\api\v1;

use App\Chat;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $chat = new Chat();
        $chat->save();
        if ($this->update(Auth::id(), $chat->id)&& $this->update($request->user_id, $chat->id)) {

            return response()->json(["message" => 'Chat Created Successfully'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $Chat = Chat::find($id)->first();
        return response()->json(["messages" => $Chat->messages, "users" => $Chat->users], 200);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chat::destroy($id);
        return response()->json(['message' => "hi from the other side"], 200);
    }
}
