<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        Chat::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        event(new MessageSent($request->sender_id, $request->receiver_id, $request->message));

        return response()->json([
            'success' => 'true'
        ]);
    }

    public function show($id)
    {
        $sender_id = auth()->user()->id;
        $chat = Chat::whereIn('receiver_id', [$sender_id, $id])->orWhereIn('sender_id', [$sender_id, $id])->get();

        return response()->json([
            'success' => true,
            'data' => $chat
        ]);
    }
}
