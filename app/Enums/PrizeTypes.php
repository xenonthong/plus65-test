<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class PrizeTypes
 *
 * @package App\Enums
 *
 * @method static PrizeTypes FIRST()
 * @method static PrizeTypes SECOND()
 * @method static PrizeTypes THIRD()
 */
class PrizeTypes extends Enum
{
    private const FIRST  = 'first prize';
    private const SECOND = 'second prize';
    private const THIRD  = 'third prize';
}