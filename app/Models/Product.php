<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'part_number',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function installations(): HasMany
    {
        return $this->hasMany(Installation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
