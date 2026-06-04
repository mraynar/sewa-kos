<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    public $timestamps = true;

    const UPDATED_AT = null;

    protected $table = 'maintenance_requests';

    protected $fillable = [
        'user_id',
        'booking_id',
        'issue_name',
        'description',
        'photo',
        'location',
        'status',
        'employee_id',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Scope a query to only include maintenance requests for a specific employee that are pending or on progress.
     */
    public function scopePendingByEmployee(Builder $query, int $employeeId): Builder
    {
        return $query->where('employee_id', $employeeId)
            ->whereIn('status', ['pending', 'on_progress']);
    }
}
