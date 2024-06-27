<?php

namespace App\Models;

use App\Models\Traits\HasMetaValueAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderMeta
 *
 * @property int $meta_id
 * @property int $order_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderMeta whereOrderId($value)
 * @mixin \Eloquent
 */
class OrderMeta extends Model
{
    use HasFactory, HasMetaValueAttribute;

    protected $table = 'order_meta';
    protected $primaryKey = 'meta_id';
    protected $fillable = ['meta_key', 'meta_value'];
    public $timestamps = false;
}
