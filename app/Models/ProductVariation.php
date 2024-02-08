<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductVariation
 *
 * @property int $id
 * @property string|null $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductVariationOption> $options
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductVariation whereName($value)
 * @mixin \Eloquent
 */
class ProductVariation extends Model
{
    use HasFactory;

    protected $table = 'product_variation';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    protected $with = ['options'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $model->options()->delete();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(ProductVariationOption::class, 'var_id', 'id');
    }
}
