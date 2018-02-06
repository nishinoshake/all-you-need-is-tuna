<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Events\MessageRecieved;
use App\Tuna\MessageBuilder;

class MessageController extends Controller
{
    const RESPONSE_RATE = 100;

    /**
     * メッセージが来たぞ
     *
     * @param \App\MessageBuilder  $builder
     * @param \Illuminate\Http\Request  $request
     */
    public function store(MessageBuilder $builder, Request $request)
    {
        $request->validate([
            'friendId' => 'required|integer',
            'text' => 'required|max:255'
        ]);

        $userMessage = $builder->user($request->friendId, $request->text);
        $tunaMessage = $builder->tuna($request->text);

        $messages = [$userMessage];

        if ($tunaMessage) {
            $messages[] = $tunaMessage;
        }

        event(new MessageRecieved($messages));

        return response()->json($messages);
    }
}
