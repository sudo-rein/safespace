<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['incident_id', 'counselor_id', 'opened_at', 'closed_at', 'outcome'])]
class CaseFile extends Model
{
    protected $table = 'case_files';

    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    public function counselor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(CaseNote::class)->latest();
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class)->latest('intervention_date');
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(FollowUp::class)->orderBy('due_date');
    }
}