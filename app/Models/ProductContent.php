<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\ProductContent
 *
 * @property int $product_id 产品ID
 * @property string|null $content 产品详情
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductContent whereProductId($value)
 * @mixin \Eloquent
 */
class ProductContent extends Model
{
    protected $table = 'product_content';
    protected $primaryKey = 'product_id';
    protected $fillable = ['product_id', 'content'];

    public $timestamps = false;
}
