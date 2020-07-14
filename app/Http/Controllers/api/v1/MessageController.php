<?php

namespace App\Http\Controllers\api\v1;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Message;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->chat_id = $request->chat_id;
        $message->user_id = Auth::id();
        $message->body = $request->body;
        if ($message->save()) {
            $message['user'] = Auth::user();
             broadcast(new NewMessage($request->chat_id, $message, Auth::user()))->toOthers();
             return response()->json([], 200);
//            return response()->json($message, 200);
        }
        return response()->json(["message" => "Something wrong happened!, Try again later"], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function show($id)
    {
        $message = Message::find($id);
        return response()->json($message->user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $message = Message::find($id);
        $message->body = $request->body;
        if ($message->save()) {
            return response()->json($message, 200);
        }
        return response()->json(["message" => "Something wrong happened!, Try again later"], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Message::destroy($id)) {
            return response()->json($id, 200);
        }
        return response()->json(["message" => "Something wrong happend!, Try again later"], 500);
    }
}
