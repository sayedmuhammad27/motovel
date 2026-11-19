<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sparepart extends Model
{
    use HasFactory;

    protected $fillable = [
        'sparepart_id',
        'name',
        'category',
        'price',
        'stock',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function ($sparepart) {
            if (empty($sparepart->sparepart_id)) {
                $latest = static::orderBy('id', 'desc')->first();
                $number = $latest ? ((int) substr($latest->sparepart_id, 4)) + 1 : 1;
                $sparepart->sparepart_id = 'SPR-' . str_pad($number, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function serviceSpareparts(): HasMany
    {
        return $this->hasMany(ServiceSparepart::class);
    }

    public function serviceDetails(): BelongsToMany
    {
        return $this->belongsToMany(ServiceDetail::class, 'service_spareparts')
            ->withPivot('quantity', 'unit_price', 'subtotal')
            ->withTimestamps();
    }
}
