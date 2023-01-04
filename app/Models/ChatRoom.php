<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;
    protected $table='sg_chat_room';
    protected $primaryKey = 'chat_room_id';

    public function room_last_message(){
        
        return $this->hasOne(ChatRoomMessage::class, 'chat_room_id', 'chat_room_id')
                        ->orderBy('sg_chat_room_messages.chat_message_id', 'desc');

    }
}
