<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;


/**
 * App\Models\Order
 *
 * @property int $id 主键
 * @property string|null $order_no 订单编号
 * @property int $order_type 订单类型,1=普通订单,2=拼单,3=超市订单,4=外卖订单
 * @property int $shop_id 门店ID
 * @property string|null $shop_name 门店名称
 * @property int $buyer_id 买家ID
 * @property string|null $buyer_name 买家账号
 * @property string|null $buyer_note 买家留言
 * @property int $seller_id 卖家ID
 * @property string|null $seller_name 卖家账号
 * @property string $discount_total 优惠金额
 * @property string $discount_tax 优惠税额
 * @property string $total
 * @property string $total_tax
 * @property int $prices_include_tax
 * @property string $payment_method
 * @property string|null $payment_method_title
 * @property int $payment_status 支付状态，1=已支付，0=未支付
 * @property \Illuminate\Support\Carbon|null $payment_at 付款时间
 * @property string $payment_cash_amount
 * @property string $shipping_method 配送方式
 * @property int $shipping_zone_id 配送区域
 * @property string $shipping_total 配送费
 * @property string $shipping_tax
 * @property int $shipping_status 发货状态，0=未发货，1=已发货
 * @property \Illuminate\Support\Carbon|null $shipping_at 发货时间
 * @property array|null $shipping_lines
 * @property int $buyer_rate 买家评价状态，0=未评价，1=已评价
 * @property int $seller_rate 卖家评价状态，0=未评价，1=已评价
 * @property int $buyer_deleted 买家已删除
 * @property int $seller_deleted 卖家已删除
 * @property string|null $out_trade_no 第三方支付订单号
 * @property array|null $fee_lines 费用列表
 * @property array|null $discount_lines 优惠列表
 * @property array|null $shipping 配送地址
 * @property array|null $billing 账单地址
 * @property int $deliveryer_id 配送员
 * @property string|null $created_via
 * @property array|null $meta_data
 * @property string $status 订单状态
 * @property int $is_modified
 * @property string|null $short_code
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $completed_at 完成时间
 * @property-read \App\Models\User|null $buyer
 * @property-read \App\Models\Deliveryer|null $deliveryer
 * @property-read mixed $links
 * @property-read array|\Illuminate\Contracts\Translation\Translator|string|null $pay_status_des
 * @property-read mixed|null $status_des
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderNote> $notes
 * @property-read int|null $notes_count
 * @property-read \App\Models\User|null $seller
 * @property-read \App\Models\ShippingZone|null $shippingZone
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\UserTransaction|null $transaction
 * @method static Builder|Order filter(array $input = [], $filter = null)
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Order query()
 * @method static Builder|Order simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|Order whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Order whereBilling($value)
 * @method static Builder|Order whereBuyerDeleted($value)
 * @method static Builder|Order whereBuyerId($value)
 * @method static Builder|Order whereBuyerName($value)
 * @method static Builder|Order whereBuyerNote($value)
 * @method static Builder|Order whereBuyerRate($value)
 * @method static Builder|Order whereCompletedAt($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCreatedVia($value)
 * @method static Builder|Order whereDeliveryerId($value)
 * @method static Builder|Order whereDiscountLines($value)
 * @method static Builder|Order whereDiscountTax($value)
 * @method static Builder|Order whereDiscountTotal($value)
 * @method static Builder|Order whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Order whereFeeLines($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereIsModified($value)
 * @method static Builder|Order whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Order whereMetaData($value)
 * @method static Builder|Order whereOrderNo($value)
 * @method static Builder|Order whereOrderType($value)
 * @method static Builder|Order whereOutTradeNo($value)
 * @method static Builder|Order wherePaymentAt($value)
 * @method static Builder|Order wherePaymentCashAmount($value)
 * @method static Builder|Order wherePaymentMethod($value)
 * @method static Builder|Order wherePaymentMethodTitle($value)
 * @method static Builder|Order wherePaymentStatus($value)
 * @method static Builder|Order wherePricesIncludeTax($value)
 * @method static Builder|Order whereSellerDeleted($value)
 * @method static Builder|Order whereSellerId($value)
 * @method static Builder|Order whereSellerName($value)
 * @method static Builder|Order whereSellerRate($value)
 * @method static Builder|Order whereShipping($value)
 * @method static Builder|Order whereShippingAt($value)
 * @method static Builder|Order whereShippingLines($value)
 * @method static Builder|Order whereShippingMethod($value)
 * @method static Builder|Order whereShippingStatus($value)
 * @method static Builder|Order whereShippingTax($value)
 * @method static Builder|Order whereShippingTotal($value)
 * @method static Builder|Order whereShippingZoneId($value)
 * @method static Builder|Order whereShopId($value)
 * @method static Builder|Order whereShopName($value)
 * @method static Builder|Order whereShortCode($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereTotal($value)
 * @method static Builder|Order whereTotalTax($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use Filterable, HasDates;

    const ORDER_STATUS_UNPAID = 'unpaid'; //待付款
    const ORDER_STATUS_PAID = 'paid'; //已付款
    const ORDER_STATUS_SEND = 'send'; //已发货
    const ORDER_STATUS_SUCCESS = 'success'; //交易成功
    const ORDER_STATUS_REFUNDING = 'refunding'; //退款中
    const ORDER_STATUS_CANCELLED = 'cancelled'; //已取消
    const ORDER_STATUS_COMPLETED = 'completed'; //已完成
    const ORDER_STATUS_PENDING = 'pending'; //待处理
    const ORDER_STATUS_PROCESSIING = 'processing'; //处理中
    const ORDER_STATUS_DELIVERING = 'delivering'; //配送中
    const ORDER_STATUS_FAILED = 'failed';
    const ORDER_STATUS_REFUNDED = 'refunded';

    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'order_no', 'order_type', 'shop_id', 'shop_name', 'buyer_id', 'buyer_name', 'buyer_note',
        'seller_id', 'seller_name', 'discount_total', 'discount_tax', 'total', 'total_tax', 'prices_include_tax',
        'payment_method', 'payment_method_title', 'payment_status', 'payment_at', 'payment_cash_amount',
        'shipping_method', 'shipping_zone_id', 'shipping_total', 'shipping_tax', 'shipping_status', 'shipping_at',
        'buyer_rate', 'seller_rate', 'buyer_deleted', 'seller_deleted', 'out_trade_no', 'fee_lines', 'discount_lines', 'shipping',
        'billing', 'deliveryer_id', 'status', 'created_at', 'updated_at', 'completed_at', 'is_modified', 'short_code',
        'meta_data', 'shipping_lines'
    ];
    protected $dates = [
        'payment_at',
        'shipping_at',
        'completed_at'
    ];
    protected $appends = [
        'status_des',
        'links'
    ];

    protected $casts = [
        'fee_lines' => 'array',
        'discount_lines' => 'array',
        'shipping' => 'array',
        'billing' => 'array',
        'shipping_lines' => 'json',
        'meta_data' => 'json'
    ];

    protected $with = ['items', 'buyer', 'seller', 'shop', 'transaction', 'deliveryer', 'shippingZone'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::deleting(function (Order $order) {
            $order->items()->delete();
            $order->notes()->delete();
        });

        static::creating(function ($model) {
            if (!$model->short_code) {
                if ($code = Order::findAvalaibleCode()) {
                    $model->short_code = $code;
                }
            }
        });
    }

    /**
     * @return mixed|null
     */
    public function getStatusDesAttribute()
    {
        return is_null($this->status) ?: trans('order.order_statuses.' . $this->status);
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getPayStatusDesAttribute()
    {
        return is_null($this->payment_status) ?: trans('trade.pay_states.' . $this->payment_status);
    }

    public function getLinksAttribute()
    {
        return [
            'invoice' => route('order.invoice', Hashids::encodeHex($this->id)),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|OrderItem
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(OrderNote::class, 'order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Shop
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|UserTransaction
     */
    public function transaction()
    {
        return $this->hasOne(UserTransaction::class, 'out_trade_no', 'order_no');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Deliveryer
     */
    public function deliveryer()
    {
        return $this->belongsTo(Deliveryer::class, 'deliveryer_id', 'id');
    }

    public function shippingZone()
    {
        return $this->belongsTo(ShippingZone::class, 'shipping_zone_id', 'id');
    }

    /**
     * @param $order_no
     * @return Builder|Model|Order|object|null
     */
    public static function findByOrderNo($order_no)
    {
        return static::query()->where('order_no', $order_no)->first();
    }

    public function markAsPaid()
    {
        $this->forceFill([
            'status' => self::ORDER_STATUS_PROCESSIING,
            'payment_status' => 1,
            'payment_at' => now()
        ])->save();
    }


    public function markAsUnPaid()
    {
        $this->forceFill([
            'status' => self::ORDER_STATUS_PENDING,
            'payment_status' => 0,
            'payment_at' => null
        ])->save();
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return $this->payment_status == 1;
    }

    /**
     * @return bool
     */
    public function isUnPaid()
    {
        return $this->payment_status == 0;
    }

    public function markAsShipped()
    {
        $this->forceFill([
            'status' => self::ORDER_STATUS_DELIVERING,
            'shipping_status' => 1,
            'shipping_at' => now()
        ])->save();
    }

    /**
     * @return bool
     */
    public function isShipped()
    {
        return $this->shipping_status == 1;
    }

    public function markAsCancelled()
    {
        $this->forceFill([
            'status' => self::ORDER_STATUS_CANCELLED
        ])->save();
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status == self::ORDER_STATUS_CANCELLED;
    }

    public function markAsCompleted()
    {
        $this->forceFill([
            'status' => self::ORDER_STATUS_COMPLETED,
            'completed_at' => now()
        ])->save();
    }

    public static function findAvalaibleCode()
    {
        $exists = false;
        while (!$exists) {
            $code = str_pad(rand(0, 9999), 4, '0');
            if (!static::query()->where('short_code', $code)->whereDate('created_at', now())->exists()) {
                $exists = true;
                return $code;
            }
        }
        return false;
    }
}
