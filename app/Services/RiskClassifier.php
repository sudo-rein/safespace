<?php

namespace App\Services;

use App\Models\Keyword;

class RiskClassifier
{
    /**
     * @return array{
     *   risk: string,
     *   matched_words: array<int, array{word: string, category: string, group: string}>,
     *   urgent: bool,
     *   reason: string
     * }
     */
    public function classify(string $text, bool $someoneHurt = false): array
    {
        $normalized = ' ' . TextNormalizer::normalize($text) . ' ';

        $keywords = Keyword::with('category')
            ->where('is_active', true)
            ->get()
            // longest first, so phrases match before single words
            ->sortByDesc(fn ($k) => mb_strlen($k->word));

        $matches = [];
        $urgent = false;

        foreach ($keywords as $keyword) {
            $needle = ' ' . TextNormalizer::normalize($keyword->word) . ' ';

            // spaces on both sides = whole-word / whole-phrase match
            if (str_contains($normalized, $needle)) {
                $matches[] = [
                    'word' => $keyword->word,
                    'category' => $keyword->category->name,
                    'group' => $keyword->category->severity_group,
                ];

                if ($keyword->category->is_urgent) {
                    $urgent = true;
                }
            }
        }

        $hasMediumHigh = collect($matches)->contains('group', 'medium_high');

        if ($hasMediumHigh) {
            $risk = 'medium_high';
            $reason = 'Matched a physical, threat, weapon, self-harm, sexual, or cyber word.';
        } elseif ($someoneHurt) {
            $risk = 'medium_high';
            $reason = 'Reporter indicated someone was physically hurt.';
        } else {
            $risk = 'low';
            $reason = count($matches)
                ? 'Verbal or social bullying words only.'
                : 'No risk keywords found.';
        }

        return [
            'risk' => $risk,
            'matched_words' => $matches,
            'urgent' => $urgent,
            'reason' => $reason,
        ];
    }
}