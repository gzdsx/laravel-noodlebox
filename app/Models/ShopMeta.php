<?php

namespace App\Models;

use App\Models\Traits\HasMetaValueAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShopMeta
 *
 * @property int $meta_id
 * @property int $shop_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShopMeta whereShopId($value)
 * @mixin \Eloquent
 */
class ShopMeta extends Model
{
    use HasFactory, HasMetaValueAttribute;

    protected $table = 'shop_meta';
    protected $fillable = ['shop_id', 'meta_key', 'meta_value'];
    protected $hidden = ['shop_id'];

    public $timestamps = false;
}
