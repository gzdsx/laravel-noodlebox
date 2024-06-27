<?php

namespace App\Models;

use App\Models\Traits\HasMetaValue;
use App\Models\Traits\HasMetaValueAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostMeta
 *
 * @property int $meta_id
 * @property int $post_id
 * @property string $meta_key
 * @property string|null $meta_value
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta whereMetaValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostMeta wherePostId($value)
 * @mixin \Eloquent
 */
class PostMeta extends Model
{
    use HasMetaValueAttribute;

    protected $table = 'post_meta';
    protected $primaryKey = 'meta_id';
    protected $fillable = ['post_id', 'meta_key', 'meta_value'];

    public $timestamps = false;
}
