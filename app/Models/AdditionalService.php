<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalService extends Model
{
    protected $fillable = [
        'service_name',
        'duration_type',
        'service_price',  
    ];
}
