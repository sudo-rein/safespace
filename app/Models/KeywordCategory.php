<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'severity_group', 'is_urgent'])]
class KeywordCategory extends Model
{
    protected function casts(): array
    {
        return ['is_urgent' => 'boolean'];
    }

    public function keywords(): HasMany
    {
        return $this->hasMany(Keyword::class, 'category_id');
    }
}