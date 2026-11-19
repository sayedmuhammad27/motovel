<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServiceRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'vehicle_id',
        'customer_id',
        'complaint',
        'service_date',
        'status',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function ($service) {
            if (empty($service->service_id)) {
                $latest = static::orderBy('id', 'desc')->first();
                $number = $latest ? ((int) substr($latest->service_id, 4)) + 1 : 1;
                $service->service_id = 'SRV-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceDetail(): HasOne
    {
        return $this->hasOne(ServiceDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
