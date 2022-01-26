<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        Chat::create([
            'sender_id' => $request->sender_id,
            'room_id' => $request->room_id,
            'message' => $request->message
        ]);

        event(new MessageSent($request->room_id, $request->sender_id, $request->message));

        return response()->json([
            'success' => 'true'
        ]);
    }

    public function show($id)
    {
        $chat = Chat::where('room_id', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $chat
        ]);
    }
}
