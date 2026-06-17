<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Booking extends Model
{
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'total_price',
        'status',
        'payment_token',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function additionalServices(): BelongsToMany
    {
        return $this->belongsToMany(AdditionalService::class, 'booking_service')
            ->withPivot('quantity', 'price_at_purchase')
            ->withTimestamps();
    }

    /**
     * Derived display status computed from check_in, check_out, and the stored status.
     * Only 'paid' bookings are subdivided; other statuses are returned as-is.
     *
     * @return string One of: 'Lunas', 'Ditempati', 'Selesai', 'pending', 'expired', 'canceled'
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->status !== 'paid') {
            return $this->status;
        }

        $today = Carbon::today();
        $checkIn = Carbon::parse($this->check_in)->startOfDay();
        $checkOut = Carbon::parse($this->check_out)->startOfDay();

        if ($today->lt($checkIn)) {
            return 'Lunas';
        }

        if ($today->lte($checkOut)) {
            return 'Ditempati';
        }

        return 'Selesai';
    }

    /**
     * Scope: bookings where the tenant is currently inside the rental period.
     * Conditions: status = 'paid' AND check_in <= today AND check_out >= today.
     */
    public function scopeCurrentlyActive(Builder $query): Builder
    {
        $today = Carbon::today()->toDateString();

        return $query
            ->where('status', 'paid')
            ->whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>=', $today);
    }
}
