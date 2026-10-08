<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['case_file_id', 'due_date', 'done_at', 'remarks', 'reminded_at'])]
class FollowUp extends Model
{
    protected $table = 'follow_ups';

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'done_at' => 'datetime',
            'reminded_at' => 'datetime'
        ];
    }

    public function caseFile(): BelongsTo
    {
        return $this->belongsTo(CaseFile::class);
    }
}