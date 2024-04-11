<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasImageAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Cart
 *
 * @property int $id 主键
 * @property string $user_id 用户ID
 * @property int $shop_id 店铺ID
 * @property int $product_id 产品ID
 * @property string|null $title 产品标题
 * @property string $image 大图
 * @property int $quantity 产品数量
 * @property string $price 商品价格
 * @property int $sku_id SKU ID
 * @property string|null $sku_title SKU名称
 * @property array|null $meta_data 附加选项
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\ProductSku|null $sku
 * @method static Builder|Cart newModelQuery()
 * @method static Builder|Cart newQuery()
 * @method static Builder|Cart query()
 * @method static Builder|Cart whereCreatedAt($value)
 * @method static Builder|Cart whereId($value)
 * @method static Builder|Cart whereImage($value)
 * @method static Builder|Cart whereMetaData($value)
 * @method static Builder|Cart wherePrice($value)
 * @method static Builder|Cart whereProductId($value)
 * @method static Builder|Cart whereQuantity($value)
 * @method static Builder|Cart whereShopId($value)
 * @method static Builder|Cart whereSkuId($value)
 * @method static Builder|Cart whereSkuTitle($value)
 * @method static Builder|Cart whereTitle($value)
 * @method static Builder|Cart whereUpdatedAt($value)
 * @method static Builder|Cart whereUserId($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    use HasImageAttribute, HasDates;

    protected $table = 'cart';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'product_id', 'shop_id', 'title',
        'quantity', 'price', 'image', 'sku_id', 'sku_title', 'meta_data'
    ];
    protected $with = ['product', 'sku', 'shop'];
    protected $hidden = ['user_id', 'shop_id'];
    protected $casts = [
        'meta_data' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Shop
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Product
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
}
