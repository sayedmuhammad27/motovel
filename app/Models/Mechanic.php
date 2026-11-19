<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mechanic extends Model
{
    use HasFactory;

    protected $fillable = [
        'mechanic_id',
        'name',
        'phone',
        'address',
        'specialty',
    ];

    protected static function booted(): void
    {
        static::creating(function ($mechanic) {
            if (empty($mechanic->mechanic_id)) {
                $latest = static::orderBy('id', 'desc')->first();
                $number = $latest ? ((int) substr($latest->mechanic_id, 4)) + 1 : 1;
                $mechanic->mechanic_id = 'MKN-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function serviceDetails(): HasMany
    {
        return $this->hasMany(ServiceDetail::class);
    }
}
