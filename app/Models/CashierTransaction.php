<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CashierTransaction
 *
 * @property int $id
 * @property string $total
 * @property string $shipping_total
 * @property string $cash_total
 * @property string $online_total
 * @property string $card_total
 * @property string $refund_total
 * @property string $cash_profit_total
 * @property string $pos_base_amount
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereCardTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereCashProfitTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereCashTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereOnlineTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction wherePosBaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereRefundTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereShippingTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CashierTransaction extends Model
{
    use HasFactory, HasDates;

    protected $table = 'cashier_transaction';
    protected $fillable = [
        'total',
        'shipping_total',
        'cash_total',
        'online_total',
        'card_total',
        'refund_total',
        'cash_profit_total',
        'pos_base_amount',
        'notes'
    ];
}
