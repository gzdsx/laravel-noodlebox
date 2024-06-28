<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Cart
 *
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property int $shop_id 店铺ID
 * @property int $product_id 产品ID
 * @property string|null $title 产品标题
 * @property string|null $image 大图
 * @property string $price 原始价格
 * @property int $quantity 产品数量
 * @property int $sku_id SKU ID
 * @property string|null $sku_title SKU名称
 * @property object|null $meta_data 元数据
 * @property string|null $purchase_via
 * @property string|null $cart_hash
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\ProductSku|null $sku
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCartHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart wherePurchaseVia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereSkuTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUserId($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    use HasFactory, HasDates;

    protected $table = 'cart';
    protected $fillable = [
        'user_id',
        'shop_id',
        'product_id',
        'title',
        'image',
        'price',
        'quantity',
        'sku_id',
        'sku_title',
        'meta_data',
        'purchase_via',
        'cart_hash'
    ];

    protected $casts = [
        'meta_data' => 'object',
    ];

    protected $with = ['shop', 'product', 'sku'];
    protected $appends = ['total'];

    public function getMetaDataAttribute($value)
    {
        return $value ? json_decode($value, true) : collect();
    }

    public function getPriceAttribute($value)
    {
        if ($this->purchase_via == 'lottery') {
            return format_amount(0);
        }

        if ($this->purchase_via == 'point') {
            return format_amount(0);
        }

        if (!$this->product) {
            return format_amount(0);
        }

        $product = $this->product;
        $meta_data = $this->meta_data;
        $price = $this->product->price;

        if (isset($meta_data['options']) && is_array($meta_data['options']) && is_array($product->variation_list)) {
            $options = $meta_data['options'];
            $variation_list = $product->variation_list;
            foreach ($variation_list as $variation) {
                if (isset($options[$variation['name']])) {
                    $val = $options[$variation['name']];
                    foreach ($variation['options'] as $option) {
                        if ($option['title'] == $val) {
                            $price += $option['price'];
                        }
                    }
                }
            }
        }

        if (isset($meta_data['additional_options']) && is_array($meta_data['additional_options']) && is_array($product->additional_options)) {
            $additional_options = $meta_data['additional_options'];
            foreach ($product->additional_options as $option) {
                if (in_array($option['title'], $additional_options)) {
                    $price += $option['price'];
                }
            }
        }

        return $price;
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Shop
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku()
    {
        return $this->belongsTo(ProductSku::class, 'sku_id', 'id');
    }

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    public function getMeta($key, $default = null)
    {
        if (is_array($this->meta_data)) {
            return collect($this->meta_data)->get($key, $default);
        }

        return collect()->get($key, $default);
    }
}
