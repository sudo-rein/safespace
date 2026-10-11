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
                    'crisis' => true,
                ];
            }
        }

        // Pick the topic with the most keyword hits
        $best = null;
        $bestScore = 0;

        foreach (config('chatbot.topics') as $topic) {
            $score = 0;
            foreach ($topic['keywords'] as $kw) {
                if (str_contains($text, ' ' . TextNormalizer::normalize($kw) . ' ')) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $best = $topic;
                $bestScore = $score;
            }
        }

        return [
            'answer' => $best['answer'] ?? config('chatbot.fallback'),
            'hotlines' => [],
            'crisis' => false,
        ];
    }
}