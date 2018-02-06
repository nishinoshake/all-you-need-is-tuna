<?php

namespace App\Tuna;

class MessageBuilder
{
    // マグロは常にゼロ
    const TUNA_KETSUBAN = 0;

    // マグロの名前は常にTuna
    const TUNA_NAME = 'Tuna';

    // 寿司ガチャの排出率
    const SUSHI_RATE = 3;

    // マグロとされる文字
    private static $words = [
        'まぐろ',
        'マグロ',
        '鮪',
        'つな',
        'ツナ',
        '築地',
        'すきやばし次郎',
        '二郎は鮨の夢を見る',
        '近畿大学',
        '近大',
        '大間',
        '渡哲也',
        '新春ドラマスペシャル',
        'tuna',
        'Jiro Dreams of Sushi',
    ];

    // 各画像のパス
    private static $imageTuna = 'https://storage.noplan.cc/demo/tuna/alive.png';
    private static $imageSushi = 'https://storage.noplan.cc/demo/tuna/sushi.png';

    /**
     * ユーザーのメッセージを作るぞ
     *
     * @param int $frinedId
     * @param string $text
     * @return array
     */
    public function user(int $friendId, string $text): array
    {
        return [
            'friendId' => $friendId,
            'name' => $this->getUsername($friendId),
            'messages' => [
                [
                    'type' => 'text',
                    'body' => $text
                ]
            ]
        ];
    }

    /**
     * まぐろのメッセージを作るぞ
     *
     * @param string $text
     * @return array
     */
    public function tuna(string $text): array
    {
        $total = $this->countTsuna($text);

        if ($total) {
            return [
                'friendId' => self::TUNA_KETSUBAN,
                'name' => self::TUNA_NAME,
                'messages' => $this->buildTunaImages($total)
            ];
        }

        return [];
    }

    /**
     * ユーザー名をアメリカの州名から適当に取得する
     *
     * @param int $num
     * @return string
     */
    public function getUsername(int $num): string
    {
        $totalStates = count(config('tuna.states'));

        return config('tuna.states')[$num % $totalStates];
    }

    /**
     * まぐろ達が何回出現するか
     *
     * @param string $text
     * @return int
     */
    public function countTsuna(string $text): int
    {
        return array_sum(array_map(function($word) use ($text) {
            return mb_substr_count($text, $word, 'UTF-8');
        }, self::$words));
    }

    /**
     * マグロの画像達を作るぞ
     *
     * @param int $total
     * @return array
     */
    public function buildTunaImages(int $total): array
    {
        $images = [];

        for ($i = 0; $i < $total; $i++) {
            $imageUrl = $this->gacha(self::SUSHI_RATE)
                ? self::$imageSushi
                : self::$imageTuna;

            $images[] = [
                'type' => 'image',
                'body' => $imageUrl
            ];
        }

        return $images;
    }

    /**
     * ガチャ
     *
     * @param int $rate
     * @return bool
     */
    public function gacha($rate): bool
    {
        return mt_rand(1, 100) <= $rate;
    }
}
