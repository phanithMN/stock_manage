<?php

namespace App\Constants;

class StockStatus
{
    public const IN = 1;
    public const OUT = 2;
    public const SPOILED = 3;
    public const RETURN = 4;

    public static function getStatuses()
    {
        return [
            self::IN => 'In',
            self::OUT => 'Out',
            self::SPOILED => 'Spoiled',
            self::RETURN => 'Return',
        ];
    }
}