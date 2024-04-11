<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductMeta
 *
 * @property int $meta_id
 * @property int $product_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductMeta whereProductId($value)
 * @mixin \Eloquent
 */
class ProductMeta extends Model
{
    protected $table = 'product_meta';
    protected $primaryKey = 'meta_id';
    protected $fillable = ['product_id', 'meta_key', 'meta_value'];

    public $timestamps = false;
}
