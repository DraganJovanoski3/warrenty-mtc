<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installation extends Model
{
    protected $fillable = [
        'company_name',
        'tax_id',
        'customer_address',
        'installer_company_name',
        'truck_number',
        'vin',
        'mileage_at_installation',
        'installation_date',
        'product_id',
        'part_number',
        'part_description',
        'invoice_number',
        'invoice_date',
        'user_id',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'installation_date' => 'date',
            'invoice_date' => 'date',
            'submitted_at' => 'datetime',
            'mileage_at_installation' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Installation $installation) {
            if (empty($installation->submitted_at)) {
                $installation->submitted_at = now();
            }
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['product_id'] ?? null, fn ($q, $id) => $q->where('product_id', $id))
            ->when($filters['date_from'] ?? null, fn ($q, $from) => $q->whereDate('installation_date', '>=', $from))
            ->when($filters['date_to'] ?? null, fn ($q, $to) => $q->whereDate('installation_date', '<=', $to))
            ->when($filters['submitted_from'] ?? null, fn ($q, $from) => $q->whereDate('submitted_at', '>=', $from))
            ->when($filters['submitted_to'] ?? null, fn ($q, $to) => $q->whereDate('submitted_at', '<=', $to))
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('company_name', 'like', "%{$search}%")
                        ->orWhere('truck_number', 'like', "%{$search}%")
                        ->orWhere('vin', 'like', "%{$search}%")
                        ->orWhere('part_number', 'like', "%{$search}%")
                        ->orWhere('invoice_number', 'like', "%{$search}%");
                });
            });
    }
}
