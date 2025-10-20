<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Akibat extends Enum
{
    const KERUGIAN_KEUANGAN = 1;
    const RESIKO_TATA_KELOLA = 2;
    const KEPATUHAN = 3;

    public static function getDescription($value): string
    {
        $result = '';
        if ((int)$value === self::KERUGIAN_KEUANGAN) {
            $result = 'Kerugian Keuangan';
        } elseif ((int)$value === self::RESIKO_TATA_KELOLA) {
            $result = 'Resiko Tata Kelola Administratif & Operasional';
        } elseif ((int)$value === self::KEPATUHAN) {
            $result = 'Compliance / Kepatuhan';
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
