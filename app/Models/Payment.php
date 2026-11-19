<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'service_registration_id',
        'service_cost',
        'sparepart_cost',
        'total_amount',
        'payment_type',
        'status',
        'notes',
        'payment_date',
    ];

    protected $casts = [
        'service_cost' => 'decimal:2',
        'sparepart_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function ($payment) {
            if (empty($payment->payment_id)) {
                $latest = static::orderBy('id', 'desc')->first();
                $number = $latest ? ((int) substr($latest->payment_id, 4)) + 1 : 1;
                $payment->payment_id = 'PAY-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function serviceRegistration(): BelongsTo
    {
        return $this->belongsTo(ServiceRegistration::class);
    }
}
