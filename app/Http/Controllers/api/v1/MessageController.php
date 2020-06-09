<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Message();
        $message->chat_id = $request->chat_id;
        $message->user_id = $request->user_id;
        $message->body = $request->body;
        if ($message->save()) {
            return response()->json($message, 200);
        }
        return response()->json(["message" => "Something wrong happend!, Try again later"], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = Message::find($id);
        $message->body = $request->body;
        if ($message->save()) {
            return response()->json($message, 200);
        }
        return response()->json(["message" => "Something wrong happend!, Try again later"], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Message::destroy($id)) {
            return response()->json($id, 200);
        }
        return response()->json(["message" => "Something wrong happend!, Try again later"], 500);
    }
}
