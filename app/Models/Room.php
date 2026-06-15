<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type_id',
        'room_number',
        'gender_type',
        'price',
        'rating',
        'facilities',
        'area_size',
        'is_electric_included',
        'is_water_included',
        'room_rules',
        'status',
    ];

    protected $casts = [
        'is_electric_included' => 'boolean',
        'is_water_included' => 'boolean',
    ];

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
    }
}
