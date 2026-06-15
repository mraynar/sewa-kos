<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
        'facilities',
        'base_price_daily',
        'base_price_weekly',
        'base_price_monthly',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
