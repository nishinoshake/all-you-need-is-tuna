<?php

namespace App\Tuna;

use Illuminate\Support\Facades\Redis;

class Friends
{
    const FRIEND_KEY = 'friend:total';

    /**
     * フレンズのIDを返す
     *
     * 被らないようにインクリメントするだけのフレンズ
     *
     * @return int
     */
    public function getFriendId(): int
    {
        if(Redis::get(self::FRIEND_KEY)){
            Redis::incr(self::FRIEND_KEY);
        } else {
            Redis::set(self::FRIEND_KEY, MessageBuilder::TUNA_KETSUBAN + 1);
        }

        return (int) Redis::get(self::FRIEND_KEY);
    }
}
