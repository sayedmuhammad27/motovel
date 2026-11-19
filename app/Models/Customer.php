<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'phone',
        'address',
        'occupation',
    ];

    protected static function booted(): void
    {
        static::creating(function ($customer) {
            if (empty($customer->customer_id)) {
                $latest = static::orderBy('id', 'desc')->first();
                $number = $latest ? ((int) substr($latest->customer_id, 4)) + 1 : 1;
                $customer->customer_id = 'PLG-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function serviceRegistrations(): HasMany
    {
        return $this->hasMany(ServiceRegistration::class);
    }
}
