<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasMetas;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\Shop
 *
 * @property int $id 店铺ID
 * @property int $user_id 店主UID
 * @property string|null $name 店铺名称
 * @property int $type 店铺类型，1=总店，2=分店
 * @property string $logo 店铺标志
 * @property string|null $country 国家
 * @property string|null $province 所在省
 * @property string|null $city 所在市
 * @property string|null $district 所在县
 * @property string|null $address_1 地址1
 * @property string|null $address_2 地址2
 * @property float|null $latitude 纬度
 * @property float|null $longitude 经度
 * @property int $views 浏览次数
 * @property int $subscribe_num 关注量
 * @property int $visitors 访客数
 * @property string $turnover 营业额
 * @property int $month_sales 月销量
 * @property int $cumulative_sales 累计销量
 * @property string|null $description 店铺简介
 * @property float|null $scores 评分
 * @property int $verify_status 认证状态
 * @property int $bond_status 缴纳保证金状态
 * @property string|null $last_reviews 最新评价
 * @property string|null $notice 店铺公告
 * @property int $is_seven_refund 7天无理由退货
 * @property int $is_pay_reduce_stock 付款减库存
 * @property int $is_refund_rollback_stock 退货恢复库存
 * @property string|null $status
 * @property Carbon|null $created_at 开店时间
 * @property Carbon|null $updated_at 更新时间
 * @property-read array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null $bond_status_des
 * @property-read string $formatted_address
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read string $status_des
 * @property-read array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null $verify_status_des
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShopImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShopMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $subscribedUsers
 * @property-read int|null $subscribed_users_count
 * @property-read \App\Models\User|null $user
 * @method static Builder|Shop filter(array $input = [], $filter = null)
 * @method static Builder|Shop newModelQuery()
 * @method static Builder|Shop newQuery()
 * @method static Builder|Shop paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Shop query()
 * @method static Builder|Shop simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|Shop whereAddress1($value)
 * @method static Builder|Shop whereAddress2($value)
 * @method static Builder|Shop whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Shop whereBondStatus($value)
 * @method static Builder|Shop whereCity($value)
 * @method static Builder|Shop whereCountry($value)
 * @method static Builder|Shop whereCreatedAt($value)
 * @method static Builder|Shop whereCumulativeSales($value)
 * @method static Builder|Shop whereDescription($value)
 * @method static Builder|Shop whereDistrict($value)
 * @method static Builder|Shop whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Shop whereId($value)
 * @method static Builder|Shop whereIsPayReduceStock($value)
 * @method static Builder|Shop whereIsRefundRollbackStock($value)
 * @method static Builder|Shop whereIsSevenRefund($value)
 * @method static Builder|Shop whereLastReviews($value)
 * @method static Builder|Shop whereLatitude($value)
 * @method static Builder|Shop whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Shop whereLogo($value)
 * @method static Builder|Shop whereLongitude($value)
 * @method static Builder|Shop whereMonthSales($value)
 * @method static Builder|Shop whereName($value)
 * @method static Builder|Shop whereNotice($value)
 * @method static Builder|Shop whereProvince($value)
 * @method static Builder|Shop whereScores($value)
 * @method static Builder|Shop whereStatus($value)
 * @method static Builder|Shop whereSubscribeNum($value)
 * @method static Builder|Shop whereTurnover($value)
 * @method static Builder|Shop whereType($value)
 * @method static Builder|Shop whereUpdatedAt($value)
 * @method static Builder|Shop whereUserId($value)
 * @method static Builder|Shop whereVerifyStatus($value)
 * @method static Builder|Shop whereViews($value)
 * @method static Builder|Shop whereVisitors($value)
 * @mixin \Eloquent
 */
class Shop extends Model
{
    use HasDates, Filterable, HasMetas;

    const STATUS_OPENING = 'opening';
    const STATUS_CLOSED = 'closed';

    protected $table = 'shop';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'name', 'type', 'logo', 'country', 'province', 'city', 'district', 'address_1', 'address_2',
        'latitude', 'longitude', 'views', 'subscribe_num', 'visitors', 'turnover', 'month_sales', 'cumulative_sales',
        'description', 'scores', 'verify_status', 'bond_status', 'last_reviews', 'notice', 'is_seven_refund',
        'is_pay_reduce_stock', 'is_refund_rollback_stock', 'status'
    ];
    protected $with = ['user', 'metas', 'images'];
    protected $appends = ['meta_data', 'status_des', 'verify_status_des', 'bond_status_des', 'formatted_address'];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::saving(function (Shop $shop) {
            if (!$shop->user_id) {
                $shop->user()->associate(Auth::user());
            }
        });
        static::deleting(function (Shop $shop) {
            $shop->images()->delete();
            $shop->metas()->delete();
        });
    }

    /**
     * @param $value
     * @return string
     */
    public function getLogoAttribute($value)
    {
        return $value ? image_url($value) : null;
    }

    public function setLogoAttribute($value)
    {
        $this->attributes['logo'] = strip_image_url($value);
    }

    /**
     * @return string
     */
    public function getStatusDesAttribute()
    {
        return trans('shop.statuses.' . $this->status);
    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getVerifyStatusDesAttribute()
    {
        return trans('shop.verify_status.' . $this->verify_status);
    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getBondStatusDesAttribute()
    {
        return trans('shop.bond_status.' . $this->bond_status);
    }

    /**
     * @return string
     */
    public function getFormattedAddressAttribute()
    {
        if ($this->province == $this->city) {
            $addressline = $this->city . $this->district;
        } else {
            $addressline = $this->province . $this->city . $this->district;
        }
        return $addressline . ' ' . $this->address_1 . ' ' . $this->address_2;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ShopImage::class, 'shop_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id', 'id');
    }

    public function metas()
    {
        return $this->hasMany(ShopMeta::class, 'shop_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|User
     */
    public function subscribedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'shop_subscribe',
            'shop_id',
            'user_id',
            'id',
            'id'
        )->withTimestamps();
    }

    public function markAsClosed()
    {
        $this->forceFill(['status' => self::STATUS_CLOSED])->save();
    }

    /**
     * @return bool
     */
    public function isClosed()
    {
        return $this->status == self::STATUS_CLOSED;
    }

    public function markAsOpening()
    {
        $this->forceFill(['status' => self::STATUS_OPENING])->save();
    }

    public function isOpening()
    {
        return $this->status == self::STATUS_OPENING;
    }
}
