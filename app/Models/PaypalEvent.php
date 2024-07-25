<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalEvent extends Model
{
    use HasFactory, HasDates;

    protected $table = 'paypal_events';
    protected $fillable = ['data'];
    protected $casts = [
        'data' => 'array'
    ];
}
