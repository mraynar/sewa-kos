<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    protected $table = 'booking_service';

    protected $fillable = ['booking_id', 'additional_service_id', 'quantity', 'price_at_purchase', 'employee_id', 'service_status'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function additionalService()
    {
        return $this->belongsTo(AdditionalService::class, 'additional_service_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Scope a query to only include services assigned to a specific employee.
     */
    public function scopeByEmployee(Builder $query, int $employeeId): Builder
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope a query to only include services with a specific status.
     */
    public function scopeByStatus(Builder $query, ?string $status): Builder
    {
        if ($status === 'pending') {
            return $query->whereNull('service_status');
        }

        return $query->where('service_status', $status);
    }
}
