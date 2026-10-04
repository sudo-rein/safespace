<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['incident_id', 'student_id', 'name_text', 'role'])]
class IncidentParty extends Model
{
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}