<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'tracking_code', 'reporter_user_id', 'report_mode', 'incident_date', 'incident_time',
    'location_id', 'description', 'repeated', 'someone_hurt',
    'status', 'risk_level', 'risk_source', 'submitted_at',
])]
class Incident extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
            'repeated' => 'boolean',
            'someone_hurt' => 'boolean',
            'submitted_at' => 'datetime',
        ];
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_user_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function parties(): HasMany
    {
        return $this->hasMany(IncidentParty::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(IncidentAttachment::class);
    }

    public function assessment(): HasOne
    {
        return $this->hasOne(RiskAssessment::class)->latestOfMany();
    }

    public function overrides(): HasMany
    {
        return $this->hasMany(RiskOverride::class)->latest();
    }

    public function caseFile(): HasOne
{
    return $this->hasOne(CaseFile::class);
}

    /** Simplified status shown to students (never counselor details). */
    public function studentStatus(): string
    {
        return match ($this->status) {
            'submitted' => 'Received',
            'under_review', 'dismissed' => 'Being Reviewed',
            'case_opened', 'intervention', 'monitoring' => 'In Progress',
            'resolved', 'closed' => 'Resolved',
            default => 'Received',
        };
    }
}