<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }


    public function broadcastOn()
    {
//        return new Channel('conversation.' . $this->message->conversation_id);

         Log::info('Broadcasting to: conversation.' . $this->message->conversation_id);
         return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastAs()
    {
        Log::info('Broadcasting as: message.sent');
        return 'message.sent';
    }

    public function broadcastWith()
    {

        Log::info('Broadcasting with: ' . json_encode($this->message));
        return [
            'id'              => $this->message->id,
            'content'         => $this->message->content,
            'image_url'       => $this->message->image_url,
            'sender'          => $this->message->sender,
            'sender_id'       => $this->message->sender_id,
            'conversation_id' => $this->message->conversation_id,
            'created_at'      => $this->message->created_at->format('H:i A'),
            'isSender'        => false,
        ];
    }

}
