<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['incident_id', 'file_path', 'original_name', 'file_type', 'size'])]
class IncidentAttachment extends Model
{
    public function incident(): BelongsTo
    {
        return $this->belongsTo(Incident::class);
    }
}