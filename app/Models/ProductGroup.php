<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductGroup
 *
 * @property int $id 主键
 * @property int $user_id 团长ID
 * @property int $product_id 产品ID
 * @property int $required_num 需求人数
 * @property string $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 修改时间
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductGroupItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereRequiredNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGroup whereUserId($value)
 * @mixin \Eloquent
 */
class ProductGroup extends Model
{
    use HasDates;

    protected $table = 'product_group';
    protected $primaryKey = 'group_id';
    protected $fillable = ['user_id', 'product_id', 'order_id', 'required_num', 'status'];
    protected $with = ['user'];

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
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(ProductGroupItem::class, 'group_id', 'group_id');
    }
}
