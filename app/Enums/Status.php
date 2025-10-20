<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Status extends Enum
{
    const OPEN = 1;
    const PROGRESS = 2;
    const CLOSED = 3;

    public static function getDescription($value): string
    {
        $result = '';
        if ((int)$value === self::OPEN) {
            $result = 'Open';
        } elseif ((int)$value === self::PROGRESS) {
            $result = 'On Progress';
        } elseif ((int)$value === self::CLOSED) {
            $result = 'Closed';
        }
        return $result;
    }

    public static function asOptions()
    {
        $options = [];
        foreach (self::asSelectArray() as $key => $value) {
            array_push($options, ['value' => $key, 'label' => $value]);
        }
        return $options;
    }
}
