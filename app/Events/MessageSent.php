<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room_id;
    public $sender_id;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($room_id, $sender_id, $message)
    {
        $this->room_id = $room_id;
        $this->sender_id = $sender_id;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->room_id);
    }

    public function broadcastAs()
    {
        return 'messageSent';
    }
}
