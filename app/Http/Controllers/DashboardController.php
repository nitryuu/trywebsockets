<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $rooms = ChatRoom::with('receiver', 'sender')->where('sender_id', $user_id)->orWhere('receiver_id', $user_id)->get();

        $rooms->map(function ($room) use ($user_id) {
            $receiver_id = $room->receiver->id;

            if ($receiver_id != $user_id) {
                $room->chatTo = $room->receiver;
            } else {
                $room->chatTo = $room->sender;
            }

            unset(
                $room->receiver_id,
                $room->sender_id
            );
        });

        return view('dashboard', compact('rooms'));
    }
}
