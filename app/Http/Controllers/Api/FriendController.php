<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Tuna\Friends;

class FriendController extends Controller
{
    /**
     * 新しいフレンズが来たぞ
     *
     * @param \App\Friends  $friends
     * @param \Illuminate\Http\Request  $request
     */
    public function store(Friends $friends, Request $request)
    {
        return response()->json([
            'friendId' => $friends->getFriendId()
        ]);
    }
}
