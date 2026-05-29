<?php

namespace App\Models;

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
}
