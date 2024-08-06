<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

/**
 * App\Models\CashierTransaction
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $base_amount
 * @property string $shipping_total
 * @property string $cash_total
 * @property string $online_total
 * @property string $card_total
 * @property string $cost_total
 * @property string $refund_total
 * @property string $actual_total
 * @property string $pos_balance
 * @property string $total
 * @property string|null $notes
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $links
 * @property-read mixed $net_total
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereActualTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereBaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereCardTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereCashTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereCostTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereOnlineTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction wherePosBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereRefundTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereShippingTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereUserId($value)
 * @mixin \Eloquent
 */
class CashierTransaction extends Model
{
    use HasFactory, HasDates;

    protected $table = 'cashier_transaction';
    protected $fillable = [
        'user_id',
        'base_amount',
        'shipping_total',
        'cash_total',
        'online_total',
        'card_total',
        'refund_total',
        'actual_total',
        'pos_balance',
        'total',
        'notes',
        'status'
    ];
    protected $appends = ['net_total', 'links'];
    protected $with = ['user'];

    public function getNetTotalAttribute()
    {
        return format_amount($this->total - $this->refund_total - $this->shipping_total);
    }

    public function getLinksAttribute()
    {
        return [
            'invoice' => [
                'href' => URL::signedRoute('invoice.cashier.transaction', $this->id),
                'method' => 'GET'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
