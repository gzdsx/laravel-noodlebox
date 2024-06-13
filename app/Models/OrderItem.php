<?php

namespace App\Models;

use App\Models\Traits\HasImageAttribute;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\OrderItem
 *
 * @property int $id 主键
 * @property int $order_id 订单ID
 * @property int $product_id 商品ID
 * @property string|null $title 商品名称
 * @property string $price 商品价格
 * @property int $quantity 商品数量
 * @property string $image 商品图片
 * @property array|null $meta_data
 * @property int|null $sku_id 属性ID
 * @property string|null $sku_title 商品属性
 * @property int $is_gift 是否赠品
 * @property string $subtotal 小计
 * @property string $total 合计
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Refund|null $refund
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereIsGift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereSkuTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereTotal($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    use HasImageAttribute;

    protected $table = 'order_item';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id', 'product_id', 'title', 'price', 'quantity', 'image',
        'meta_data', 'sku_id', 'sku_title', 'is_gift', 'status', 'subtotal', 'total'
    ];
    protected $casts = [
        'meta_data' => 'json'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function refund()
    {
        return $this->hasOne(Refund::class, 'trade_id', 'trade_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
