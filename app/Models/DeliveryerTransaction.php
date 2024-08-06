<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

/**
 * App\Models\DeliveryerTransaction
 *
 * @property int $id
 * @property int $deliveryer_id
 * @property string $base_amount 底金
 * @property string $shipping_total
 * @property string $online_total
 * @property string $card_total
 * @property string $cash_total
 * @property string $cost_total
 * @property string $actual_total
 * @property string $total
 * @property string|null $notes
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Deliveryer|null $deliveryer
 * @property-read mixed $links
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereActualTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereBaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereCardTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereCashTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereCostTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereDeliveryerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereOnlineTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereShippingTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DeliveryerTransaction extends Model
{
    use HasFactory, HasDates;

    const STATUS_PENDING = 'pending';
    const STATUS_SETTLED = 'settled';

    protected $table = 'deliveryer_transaction';
    protected $fillable = [
        'deliveryer_id',
        'base_amount',
        'shipping_total',
        'cash_total',
        'online_total',
        'card_total',
        'cost_total',
        'actual_total',
        'total',
        'notes',
        'status'
    ];
    protected $appends = ['links'];

    public function getLinksAttribute()
    {
        return [
            'invoice' => [
                'href' => URL::signedRoute('invoice.deliveryer.transaction', $this->id),
                'method' => 'GET'
            ]
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Deliveryer
     */
    public function deliveryer()
    {
        return $this->belongsTo(Deliveryer::class, 'deliveryer_id', 'id');
    }

    public function isSettled()
    {
        return $this->status === self::STATUS_SETTLED;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Order
     */
    public function orders()
    {
        return $this->belongsToMany(
            Order::class,
            'deliveryer_transaction_order',
            'transaction_id',
            'order_id',
            'id',
            'id'
        );
    }
}
