<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Message;
use App\Notifications\NewMessageNotification;

public function store(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'content' => 'required|string|max:1000'
    ]);

    $message = Message::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $request->receiver_id,
        'content' => $request->content
    ]);

    $receiver = User::find($request->receiver_id);

    if ($receiver && $receiver->role === 'admin') {
        $receiver->notify(new NewMessageNotification($message));
    }

    return response()->json([
        'message' => 'Message sent successfully',
        'data' => $message
    ], 201);
}

