<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasMetas;
use App\Support\BulkSMS;
use App\Support\PrintNode;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
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
 * @property string|null $buyer_note 订单备注
 * @property int $seller_id 卖家ID
 * @property string|null $seller_name 卖家账号
 * @property string $discount_total 优惠金额
 * @property string $discount_tax 优惠税额
 * @property string $total
 * @property string $total_tax
 * @property string $cost_total
 * @property int $prices_include_tax
 * @property string $payment_method
 * @property string|null $payment_method_title
 * @property int $payment_status 支付状态，1=已支付，0=未支付
 * @property \Illuminate\Support\Carbon|null $payment_at 付款时间
 * @property string|null $shipping_method
 * @property array $shipping_line 配送区域
 * @property string $shipping_total 配送费
 * @property string $shipping_tax
 * @property int $shipping_status 发货状态，0=未发货，1=已发货
 * @property \Illuminate\Support\Carbon|null $shipping_at 发货时间
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
 * @property string $status 订单状态
 * @property string|null $short_code
 * @property int $is_modified
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $completed_at 完成时间
 * @property-read \App\Models\User|null $buyer
 * @property-read \App\Models\Deliveryer|null $deliveryer
 * @property-read mixed $links
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read array|\Illuminate\Contracts\Translation\Translator|string|null $pay_status_des
 * @property-read mixed|null $status_des
 * @property-read mixed $subtotal
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderNote> $notes
 * @property-read int|null $notes_count
 * @property-read \App\Models\User|null $seller
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\UserTransaction|null $transaction
 * @method static Builder|Order completed()
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
 * @method static Builder|Order whereCostTotal($value)
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
 * @method static Builder|Order whereOrderNo($value)
 * @method static Builder|Order whereOrderType($value)
 * @method static Builder|Order whereOutTradeNo($value)
 * @method static Builder|Order wherePaymentAt($value)
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
 * @method static Builder|Order whereShippingLine($value)
 * @method static Builder|Order whereShippingMethod($value)
 * @method static Builder|Order whereShippingStatus($value)
 * @method static Builder|Order whereShippingTax($value)
 * @method static Builder|Order whereShippingTotal($value)
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
    use Filterable, HasDates, HasMetas;

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
    const SHIPPING_METHOD_FLATRATE = 'flat_rate';
    const SHIPPING_METHOD_LOCALPICKUP = 'local_pickup';

    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'order_no', 'order_type', 'shop_id', 'shop_name', 'buyer_id', 'buyer_name', 'buyer_note',
        'seller_id', 'seller_name', 'discount_total', 'discount_tax', 'total', 'total_tax', 'cost_total',
        'prices_include_tax', 'payment_method', 'payment_method_title', 'payment_at',
        'shipping_method', 'shipping_line', 'shipping_total', 'shipping_tax', 'shipping_at',
        'buyer_rate', 'seller_rate', 'buyer_deleted', 'seller_deleted', 'out_trade_no', 'fee_lines', 'discount_lines',
        'shipping', 'billing', 'deliveryer_id', 'status', 'is_modified', 'short_code',
    ];
    protected $appends = [
        'meta_data',
        'status_des',
        'links',
        'subtotal'
    ];
    protected $casts = [
        'fee_lines' => 'array',
        'discount_lines' => 'array',
        'billing' => 'array',
        'shipping' => 'array',
        'shipping_line' => 'array',
        'meta_data' => 'array',
        'payment_at' => 'datetime',
        'shipping_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    protected $hidden = ['metas'];

    protected $with = ['items', 'buyer', 'seller', 'shop', 'transaction', 'deliveryer', 'metas'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::deleting(function (Order $order) {
            $order->items()->delete();
            $order->notes()->delete();
            $order->metas()->delete();
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
        return is_null($this->status) ?: trans('order.status_options.' . $this->status);
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
            'invoice' => [
                'href' => URL::signedRoute('invoice.order', $this->id),
                'method' => 'GET'
            ],
        ];
    }

    public function getSubtotalAttribute()
    {
        return $this->items->sum(function (OrderItem $item) {
            return $item->total;
        });
    }

    public function metas()
    {
        return $this->hasMany(OrderMeta::class, 'order_id', 'id');
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

    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
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
            'payment_at' => now()
        ])->save();
    }


    public function markAsUnPaid()
    {
        $this->forceFill([
            'status' => self::ORDER_STATUS_PENDING,
            'payment_at' => null
        ])->save();
    }

    /**
     * @return bool
     */
    public function isPaid()
    {
        return !is_null($this->payment_at);
    }

    public function markAsShipped()
    {
        $this->forceFill([
            'status' => self::ORDER_STATUS_DELIVERING,
            'shipping_at' => now()
        ])->save();
    }

    /**
     * @return bool
     */
    public function isShipped()
    {
        return is_null($this->shipping_at);
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

    public function isCompleted()
    {
        return !is_null($this->completed_at);
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

    public function printInvoice()
    {
        PrintNode::createPrintJob([
            'printerId' => env('PRINTNODE_PRINTER_ID'),
            'title' => 'Invoice',
            'contentType' => 'pdf_uri',
            'content' => $this->links['invoice']['href'],
            'source' => 'Noodlebox',
            'options' => [
                'bin' => '上下省纸设置',
                'dpi' => '180x180',
                'paper' => 'Roll Paper 80 x 3276 mm',
                'copies' => 1,
                'fit_to_page' => false,
                'supports_custom_paper_size' => false,
                'collate' => false
            ]
        ]);

        $this->notes()->create([
            'user_id' => auth()->id() ?: 0,
            'content' => 'Invoice printed success'
        ]);
    }

    public function sendSms()
    {
        $shipping = $this->shipping;
        if (isset($shipping['phone']) && is_array($shipping['phone'])) {
            if (is_array($shipping['phone'])) {
                $phone_address = $shipping['phone']['national_number'] ?? '';
                $phone_address .= ltrim($shipping['phone']['phone_number'] ?? '', '0');
            } else {
                $phone_address = $shipping['phone'] ?? '';
                $phone_address = ltrim($phone_address, '+');
                $phone_address = ltrim($phone_address, '0');
            }

            $message = settings('order_message_content');
            $message = str_replace('{order_no}', $this->short_code, $message);
            if ($this->buyer) {
                $message = str_replace('{points}', $this->buyer->points, $message);
            }

            BulkSMS::sendSms([
                'from' => 'NoodleBox',
                'to' => '+' . $phone_address,
                'body' => $message
            ]);

            $this->notes()->create([
                'user_id' => auth()->id() ?: 0,
                'content' => 'SMS send success'
            ]);
        }
    }
}
