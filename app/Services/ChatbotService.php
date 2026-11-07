<?php

namespace App\Services;

use App\Models\Keyword;

class ChatbotService
{
    public function reply(string $message): array
    {
        $text = ' ' . TextNormalizer::normalize($message) . ' ';

        // Safety first: any self-harm keyword overrides everything
        $selfHarm = Keyword::whereHas('category', fn ($q) => $q->where('is_urgent', true))
            ->where('is_active', true)->pluck('word');

        foreach ($selfHarm as $word) {
            if (str_contains($text, ' ' . TextNormalizer::normalize($word) . ' ')) {
                return [
                    'answer' => config('chatbot.crisis_message'),
                    'hotlines' => config('chatbot.hotlines'),
                    'links' => [['label' => 'Message the counselor through a report', 'url' => route('student.report.create')]],
                    'suggestions' => [],
                    'crisis' => true,
                ];
            }
        }

        // Pick the topic with the best score (longer phrases count more)
        $best = null;
        $bestScore = 0;

        foreach (config('chatbot.topics') as $topic) {
            $score = 0;
            foreach ($topic['keywords'] as $kw) {
                if (str_contains($text, ' ' . TextNormalizer::normalize($kw) . ' ')) {
                    $score += 1 + substr_count($kw, ' ');
                }
            }
            if ($score > $bestScore) {
                $best = $topic;
                $bestScore = $score;
            }
        }

        if (! $best) {
            return [
                'answer' => config('chatbot.fallback'),
                'hotlines' => [],
                'links' => [],
                'suggestions' => config('chatbot.suggestions'),
                'crisis' => false,
            ];
        }

        return [
            'answer' => $best['answer'],
            'hotlines' => ! empty($best['show_hotlines']) ? config('chatbot.hotlines') : [],
            'links' => array_map(
                fn ($l) => ['label' => $l['label'], 'url' => route($l['route'])],
                $best['links'] ?? []
            ),
            'suggestions' => [],
            'crisis' => false,
        ];
    }
}