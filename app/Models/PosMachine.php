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
 * @property string $status
 * @property int $deliveryer_id
 * @property int $is_cashier
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine query()
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereBaseAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereDeliveryerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereIsCashier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereSortNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosMachine whereStatus($value)
 * @mixin \Eloquent
 */
class PosMachine extends Model
{
    use HasFactory;

    const STATUS_INUSE = 'inuse';
    const STATUS_IDLE = 'idle';

    protected $table = 'pos_machine';
    protected $fillable = [
        'name',
        'base_amount',
        'sort_num',
        'status',
        'deliveryer_id',
        'is_cashier'
    ];

    public $timestamps = false;

    public function deliveryer()
    {
        return $this->belongsTo(Deliveryer::class, 'deliveryer_id', 'id');
    }
}
