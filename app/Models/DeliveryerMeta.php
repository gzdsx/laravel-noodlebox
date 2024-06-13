<?php

namespace App\Models;

use App\Models\Traits\HasMetaValueAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DeliveryerMeta
 *
 * @property int $meta_id
 * @property int|null $deliveryer_id
 * @property string|null $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerMeta whereDeliveryerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeliveryerMeta whereMetaValue($value)
 * @mixin \Eloquent
 */
class DeliveryerMeta extends Model
{
    use HasFactory, HasMetaValueAttribute;

    protected $table = 'deliveryer_meta';
    protected $fillable = ['deliveryer_id', 'meta_key', 'meta_value'];
}
