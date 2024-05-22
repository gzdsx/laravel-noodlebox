<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasImageAttribute;
use App\Models\Traits\HasMetas;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelPinyin\Facades\Pinyin;


/**
 * App\Models\Product
 *
 * @property int $id 商品ID
 * @property int $user_id 用户ID
 * @property int $shop_id 门店ID
 * @property string|null $title 宝贝标题
 * @property string|null $slug 宝贝Slug
 * @property string $image 特色图片
 * @property string|null $price 一口价
 * @property string|null $regular_price 正常价
 * @property int $purchase_limit 限购数量
 * @property int $sold 销量
 * @property int $stock 库存
 * @property int $views 浏览量
 * @property int $collect_num 收藏数量
 * @property int $comment_num 评论数
 * @property array|null $attr_list 产品属性
 * @property array|null $variation_list 产品变量
 * @property array|null $additional_options 可选项目
 * @property int $is_new 是否新品
 * @property int $is_hot 是否热销
 * @property int $is_recommend 仓储推荐
 * @property int $sticky 是否置顶
 * @property int $free_delivery 免运费
 * @property int $template_id 运费模板
 * @property int $is_weight_template 是否按重量计价
 * @property int $has_sku_attr 是否有多级型号
 * @property int $brand_id 品牌
 * @property string $status 商品状态
 * @property string|null $tax_status 含税状态
 * @property int $points 赠送积分
 * @property string|null $keywords 关键词
 * @property string|null $description 简短描述
 * @property int $sort_num 排序
 * @property string|null $icon 图标
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $collectedUsers
 * @property-read int|null $collected_users_count
 * @property-read \App\Models\ProductContent|null $content
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read array|string|null $status_des
 * @property-read \Illuminate\Contracts\Routing\UrlGenerator|string $url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductGroup> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Shop|null $shop
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductSku> $skus
 * @property-read int|null $skus_count
 * @property-read \App\Models\FreightTemplate|null $template
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Product filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAdditionalOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttrList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCollectNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCommentNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFreeDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasSkuAttr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsHot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsWeightTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurchaseLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRegularPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSticky($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTaxStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVariationList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereViews($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasDates, HasImageAttribute, HasMetas, Filterable;

    const STAUTS_ONSALE = 'onsale';
    const STAUTS_DELISTED = 'delisted';
    const STAUTS_SOLDOUT = 'soldout';
    const STAUTS_DRAFT = 'draft';

    protected $table = 'product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'user_id', 'shop_id', 'title', 'slug', 'image', 'price', 'regular_price', 'purchase_limit',
        'sold', 'stock', 'views', 'collect_num', 'comment_num', 'attr_list', 'variation_list', 'additional_options',
        'is_new', 'is_hot', 'is_recommend', 'sticky', 'free_delivery', 'template_id', '
        is_weight_template', 'has_sku_attr', 'brand_id', 'status', 'tax_status',
        'points', 'keywords', 'description', 'sort_num', 'icon', 'created_at', 'updated_at'
    ];
    protected $hidden = ['user_id'];
    protected $appends = ['url', 'status_des', 'meta_data'];
    protected $casts = [
        'attr_list' => 'array',
        'variation_list' => 'array',
        'additional_options' => 'array'
    ];
    protected $with = ['shop', 'user', 'images', 'metas', 'skus', 'categories'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::saving(function (Product $product) {
            if (!$product->user_id) {
                $product->user()->associate(Auth::id());
            }

            if (!$product->attr_list) {
                $product->attr_list = [];
            }

            if (!$product->variation_list) {
                $product->variation_list = [];
            }

            if (is_null($product->template_id)) {
                $product->template_id = 0;
            }

            if (is_null($product->shop_id)) {
                $product->shop_id = 0;
            }

            if (!$product->slug) {
                $product->slug = strtolower(Pinyin::permalink($product->title));
            }
        });

        static::saved(function (Product $product) {
            cache()->forget('front-products');
            cache()->forget('product-' . $product->id);
        });

        static::created(function (Product $product) {
            $product->content()->create();
        });

        static::deleting(function (Product $product) {
            $product->content()->delete();
            $product->images()->delete();
            $product->metas()->delete();
            $product->skus()->delete();
            $product->reviews->each->delete();

            cache()->forget('front-products');
            cache()->forget('product-' . $product->id);
        });
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrlAttribute()
    {
        return $this->id ? url('product/' . $this->slug) : null;
    }

    /**
     * @return array|string|null
     */
    public function getStatusDesAttribute()
    {
        return is_null($this->status) ? null : trans('product.statuses.' . $this->status);
    }

    public function getAttrListAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getVariationListAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getAdditionalOptionsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * @param int $amount
     * @return int
     */
    public function incrementSold($amount = 1)
    {
        return $this->increment('sold', $amount);
    }

    /**
     * @param int $amount
     * @return int
     */
    public function incrementViews($amount = 1)
    {
        return $this->increment('views', $amount);
    }

    /**
     * @param $amount
     * @return int
     */
    public function decreaseStock($amount)
    {
        return $this->newQuery()->where('id', $this->id)
            ->where('stock', '>=', $amount)
            ->decrement('stock', $amount);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|ProductContent
     */
    public function content()
    {
        return $this->hasOne(ProductContent::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|ProductSku
     */
    public function skus()
    {
        return $this->hasMany(ProductSku::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(FreightTemplate::class, 'template_id', 'template_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(ProductGroup::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_relationship',
            'object_id',
            'category_id',
            'id',
            'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|User
     */
    public function collectedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'product_collect',
            'product_id',
            'user_id',
            'id',
            'id'
        )->as('collect')
            ->withTimestamps()
            ->orderBy('product_collect.created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|ProductMeta
     */
    public function metas()
    {
        return $this->hasMany(ProductMeta::class, 'product_id', 'id');
    }

    /**
     * @return bool
     */
    public function isOnSale()
    {
        return $this->status == self::STAUTS_ONSALE;
    }

    public function isDelisted()
    {
        return $this->status == self::STAUTS_DELISTED;
    }

    public function isSoldOut()
    {
        return $this->status == self::STAUTS_SOLDOUT;
    }

    public function isDraft()
    {
        return $this->status == self::STAUTS_DRAFT;
    }

    public function markAsOnSale()
    {
        return $this->forceFill(['status' => self::STAUTS_ONSALE])->save();
    }

    public function markAsDelisted()
    {
        return $this->forceFill(['status' => self::STAUTS_DELISTED])->save();
    }

    public function markAsSoldOut()
    {
        return $this->forceFill(['status' => self::STAUTS_SOLDOUT])->save();
    }

    public function markAsDraft()
    {
        return $this->forceFill(['status' => self::STAUTS_DRAFT])->save();
    }
}
