<?php

namespace App\Services;

class TextNormalizer
{
    public static function normalize(string $text): string
    {
        $text = mb_strtolower($text);

        // common letter substitutions (leetspeak)
        $text = strtr($text, [
            '0' => 'o', '3' => 'e', '@' => 'a', '$' => 's', '!' => 'i',
        ]);

        // collapse 3+ repeated letters down to one: "pangiiiit" -> "pangit"
        $text = preg_replace('/(\p{L})\1{2,}/u', '$1', $text);

        // replace punctuation with spaces (keep letters, numbers, spaces)
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $text);

        // collapse extra whitespace
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim($text);
    }
}