<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductVariationOption
 *
 * @property int $id
 * @property int $var_id
 * @property string|null $title
 * @property string $price
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariationOption whereVarId($value)
 * @mixin \Eloquent
 */
class ProductVariationOption extends Model
{
    use HasFactory;

    protected $table = 'product_variation_option';
    protected $primaryKey = 'id';
    protected $fillable = ['var_id', 'title', 'price'];
    protected $hidden = ['var_id'];

    public $timestamps = false;
}
