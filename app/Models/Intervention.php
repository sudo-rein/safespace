<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['case_file_id', 'type', 'intervention_date', 'remarks'])]
class Intervention extends Model
{
    protected function casts(): array
    {
        return ['intervention_date' => 'date'];
    }

    public function caseFile(): BelongsTo
    {
        return $this->belongsTo(CaseFile::class);
    }
}