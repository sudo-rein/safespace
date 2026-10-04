<?php

namespace App\Services;

use App\Models\Incident;

class TrackingCodeGenerator
{
    // No 0/O/1/I so codes are easy to read aloud
    private const CHARS = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    public static function generate(): string
    {
        do {
            $code = 'SS-' . self::part(4) . '-' . self::part(4);
        } while (Incident::withTrashed()->where('tracking_code', $code)->exists());

        return $code;
    }

    private static function part(int $length): string
    {
        $out = '';
        for ($i = 0; $i < $length; $i++) {
            $out .= self::CHARS[random_int(0, strlen(self::CHARS) - 1)];
        }

        return $out;
    }
}