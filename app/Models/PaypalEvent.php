<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaypalEvent
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaypalEvent query()
 * @mixin \Eloquent
 */
class PaypalEvent extends Model
{
    use HasFactory, HasDates;

    protected $table = 'paypal_events';
    protected $fillable = ['data'];
    protected $casts = [
        'data' => 'array'
    ];
}
