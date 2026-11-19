<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'detail_id',
        'service_registration_id',
        'mechanic_id',
        'estimation',
        'service_cost',
        'status',
    ];

    protected $casts = [
        'service_cost' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function ($detail) {
            if (empty($detail->detail_id)) {
                $latest = static::orderBy('id', 'desc')->first();
                $number = $latest ? ((int) substr($latest->detail_id, 4)) + 1 : 1;
                $detail->detail_id = 'DTL-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function serviceRegistration(): BelongsTo
    {
        return $this->belongsTo(ServiceRegistration::class);
    }

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(Mechanic::class);
    }

    public function serviceSpareparts(): HasMany
    {
        return $this->hasMany(ServiceSparepart::class);
    }

    public function spareparts(): BelongsToMany
    {
        return $this->belongsToMany(Sparepart::class, 'service_spareparts')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }
}
