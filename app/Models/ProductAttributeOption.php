<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductAttributeOption
 *
 * @property int $id
 * @property int $attr_id
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption whereAttrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeOption whereValue($value)
 * @mixin \Eloquent
 */
class ProductAttributeOption extends Model
{
    protected $table = 'product_attribute_option';
    protected $primaryKey = 'id';
    protected $fillable = ['value', 'attr_id'];
    protected $hidden = ['attr_id'];

    public $timestamps = false;
}
