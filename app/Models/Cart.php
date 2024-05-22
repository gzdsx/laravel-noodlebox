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
 * @property int $quantity 产品数量
 * @property string $original_price 原始价格
 * @property int $sku_id SKU ID
 * @property string|null $sku_title SKU名称
 * @property object|null $options 可选项
 * @property array|null $additional_options 附加选项
 * @property bool $is_gift 是否赠品
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read mixed $price
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\ProductSku|null $sku
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereAdditionalOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereIsGift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereOriginalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereProductId($value)
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
        'quantity',
        'original_price',
        'sku_id',
        'sku_title',
        'options',
        'additional_options',
        'is_gift'
    ];

    protected $casts = [
        'options' => 'object',
        'additional_options' => 'array',
        'is_gift' => 'boolean'
    ];

    protected $with = ['shop', 'product', 'sku'];

    public function getOptionsAttribute($value)
    {
        return $value ? json_decode($value, true) : collect();
    }

    public function getAdditionalOptionsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
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

    public function getPriceAttribute()
    {
        if ($this->product) {
            $price = $this->product->price;
            $meta_data = [];
            if (is_array($this->meta_data)) {
                foreach ($this->meta_data as $meta) {
                    $meta_data[$meta['key']] = $meta['value'];
                }
            }

            if (is_array($this->product->variation_list)) {
                foreach ($this->product->variation_list as $variation) {
                    foreach ($variation['options'] as $option) {
                        if ($meta_data[$variation['name']] == $option['title']) {
                            $price += is_numeric($option['price']) ? $option['price'] : 0;
                        }
                    }
                }
            }

            if (is_array($this->product->additional_options)) {
                foreach ($this->product->additional_options as $option) {
                    if (in_array($option['title'], $this->additional_options)) {
                        $price += is_numeric($option['price']) ? $option['price'] : 0;
                    }
                }
            }

            return format_amount($price);
        }

        return $this->original_price;
    }
}
