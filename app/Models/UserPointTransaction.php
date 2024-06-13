<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPointTransaction
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property int $points
 * @property string|null $detail
 * @property int $order_id
 * @property int $order_item_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPointTransaction whereUserId($value)
 * @mixin \Eloquent
 */
class UserPointTransaction extends Model
{
    use HasFactory, HasDates;

    protected $table = 'user_point_transaction';
    protected $fillable = [
        'user_id',
        'points',
        'type',
        'detail',
        'order_id',
        'order_item_id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
