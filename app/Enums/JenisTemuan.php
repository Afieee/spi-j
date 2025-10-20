<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class JenisTemuan extends Enum
{
    const KERUGIAN_KEUANGAN = 1;
    const TATA_KELOLA_ADMINISTRASI = 2;
    const KINERJA_OPERASIONAL = 3;

    public static function getDescription($value): string
    {
        $result = '';
        if ((int)$value === self::KERUGIAN_KEUANGAN) {
            $result = 'Kerugian Keuangan';
        } elseif ((int)$value === self::TATA_KELOLA_ADMINISTRASI) {
            $result = 'Tata Kelola Administrasi';
        } elseif ((int)$value === self::KINERJA_OPERASIONAL) {
            $result = 'Kinerja Operasional';
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
