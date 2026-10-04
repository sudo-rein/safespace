<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['incident_id', 'system_risk', 'matched_words', 'urgent_flag', 'reason'])]
class RiskAssessment extends Model
{
    protected function casts(): array
    {
        return [
            'matched_words' => 'array',
            'urgent_flag' => 'boolean',
        ];
    }

    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }
}