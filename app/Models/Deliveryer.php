<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasImageAttribute;
use App\Models\Traits\HasMetas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

/**
 * App\Models\Deliveryer
 *
 * @property int $id 主键
 * @property string|null $name 配送员姓名
 * @property string|null $phone 配送员电话
 * @property string $image 照片
 * @property float $lng 当前位置
 * @property float $lat 当前位置
 * @property string $base_amount
 * @property string|null $color
 * @property string|null $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DeliveryerMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PosMachine> $posMachines
 * @property-read int|null $pos_machines_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DeliveryerTransaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereBaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Deliveryer extends Model
{
    use HasFactory, HasImageAttribute, HasDates, HasMetas;

    const STATUS_ONLINE = 'online';
    const STATUS_OFFLINE = 'offline';

    protected $table = 'deliveryer';
    protected $fillable = [
        'name',
        'phone',
        'image',
        'status',
        'lng',
        'lat',
        'base_amount',
        'color'
    ];
    protected $appends = ['links'];

    public function getLinksAttribute()
    {
        return [
            'report' => [
                'href' => URL::signedRoute('invoice.deliveryer.report', $this->id),
                'method' => 'GET',
            ]
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|DeliveryerMeta
     */
    public function metas()
    {
        return $this->hasMany(DeliveryerMeta::class, 'deliveryer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|PosMachine
     */
    public function posMachines()
    {
        return $this->hasMany(PosMachine::class, 'deliveryer_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'deliveryer_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|DeliveryerTransaction
     */
    public function transactions()
    {
        return $this->hasMany(DeliveryerTransaction::class, 'deliveryer_id', 'id');
    }

    public function generateTransaction()
    {
        $transaction = $this->transactions()->make([
            'base_amount' => $this->base_amount,
            'cost_total' => 0,
            'shipping_total' => 0,
            'cash_total' => 0,
            'online_total' => 0,
            'card_total' => 0,
            'refund_total' => 0,
            'actual_total' => 0,
            'pos_balance' => 0,
            'total' => 0,
            'notes' => '',
            'status' => 'pending'
        ]);

        $last = $this->transactions()->orderByDesc('created_at')->first();
        if ($last) {
            $orders = $this->orders()->completed()->where('completed_at', '>', $last->created_at)->get();
        } else {
            $orders = $this->orders()->completed()->get();
        }

        if ($orders->count()) {
            foreach ($orders as $order) {
                $transaction->total = bcadd($transaction->total, $order->total, 2);
                $transaction->cost_total = bcadd($transaction->cost_total, $order->cost_total, 2);
                $transaction->shipping_total = bcadd($transaction->shipping_total, $order->shipping_total, 2);

                if ($order->payment_method === 'cash'|| $order->payment_method === 'card') {
                    $transaction->cash_total = bcadd($transaction->cash_total, $order->total, 2);
                } elseif ($order->payment_method === 'online') {
                    $transaction->online_total = bcadd($transaction->online_total, $order->total, 2);
                } elseif ($order->payment_method === 'card_reader') {
                    $transaction->card_total = bcadd($transaction->card_total, $order->total, 2);
                } elseif ($order->payment_method === 'customize') {
                    $transaction->cash_total = bcadd($transaction->cash_total, floatval($order->getMeta('payment_with_cash_value', 0)), 2);
                    $transaction->card_total = bcadd($transaction->card_total, floatval($order->getMeta('payment_with_card_value', 0)), 2);
                }
                $transaction->orders->push($order);
            }
            $transaction->base_amount = format_amount(0);
            $transaction->actual_total = bcadd($transaction->cash_total, $transaction->cost_total, 2);
            $transaction->actual_total = bcsub($transaction->actual_total, $transaction->shipping_total, 2);
        }

        return $transaction;
    }
}
