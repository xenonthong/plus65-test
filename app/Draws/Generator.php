<?php

namespace App\Draws;

use App\Enums\PrizeTypes;
use App\Models\Number;
use App\Models\User;

class Generator
{
    /**
     * Generates a random winning number based on the prize type.
     *
     * @param string $prize_type
     *
     * @return \App\Models\Number
     */
    public static function generate(string $prize_type)
    {
        $highest_count = Number::highestCountByUsers();
        $user_ids      = null;

        if ($prize_type === (string)PrizeTypes::FIRST()) {
            $user_ids = User::withMoreThanNumberCount($highest_count - 1)->pluck('id');
        }
        else {
            $user_ids = User::withLessThanNumberCount($highest_count)->pluck('id');
        }

        return Number::whereIn('user_id', $user_ids)->inRandomOrder()->first();
    }
}