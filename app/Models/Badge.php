<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Badge
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $name
 * @property string|null $icon
 * @property int $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|Badge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge query()
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Badge whereType($value)
 * @mixin \Eloquent
 */
class Badge extends Model
{
    use HasFactory;

    protected $table = 'badge';
    protected $fillable = [
        'id',
        'type',
        'name',
        'icon',
        'sort_num'
    ];

    public $timestamps = false;
}
