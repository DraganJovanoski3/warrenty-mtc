<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\InstallationClaimConfirmation;

class Installation extends Model
{
    protected $fillable = [
        'company_name',
        'customer_email',
        'tax_id',
        'customer_address',
        'installer_company_name',
        'truck_number',
        'vin',
        'vin_photo',
        'mileage_at_installation',
        'mileage_photo',
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

        static::deleting(function (Installation $installation) {
            $installation->deleteProofPhotos();
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

    public function vinPhotoUrl(): ?string
    {
        return $this->photoUrl($this->vin_photo);
    }

    public function mileagePhotoUrl(): ?string
    {
        return $this->photoUrl($this->mileage_photo);
    }

    private function photoUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        // Serve via app route so images work without relying on public/storage symlink.
        return route('media.show', ['path' => ltrim($path, '/')]);
    }

    public function hasProofPhotos(): bool
    {
        return filled($this->vin_photo) && filled($this->mileage_photo);
    }

    public function sendClaimConfirmation(): void
    {
        if (! filled($this->customer_email)) {
            return;
        }

        $contact = (string) config('services.mtc.warranty_contact_email', 'warranty@mtctruckparts.com');

        try {
            Mail::to($this->customer_email)
                ->bcc($contact)
                ->send(new InstallationClaimConfirmation($this));
        } catch (\Throwable $e) {
            Log::warning('Failed to send installation claim confirmation.', [
                'installation_id' => $this->id,
                'customer_email' => $this->customer_email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function deleteProofPhotos(): void
    {
        foreach (['vin_photo', 'mileage_photo'] as $field) {
            if ($this->{$field}) {
                Storage::disk('public')->delete($this->{$field});
            }
        }
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
