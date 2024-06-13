<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PosMachine
 *
 * @property int $id
 * @property string|null $name
 * @property string $base_amount
 * @property int|null $sort_num
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine query()
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereBaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereSortNum($value)
 * @mixin \Eloquent
 */
class PosMachine extends Model
{
    use HasFactory;

    protected $table = 'pos_machine';
    protected $fillable = ['name', 'base_amount', 'sort_num'];

    public $timestamps = false;
}
