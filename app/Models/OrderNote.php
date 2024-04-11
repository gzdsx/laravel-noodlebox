<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\OrderNote
 *
 * @property int $id
 * @property int $order_id 订单ID
 * @property int $user_id 操作用户ID
 * @property string|null $content 操作内容
 * @property \Illuminate\Support\Carbon|null $created_at 操作时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderNote whereUserId($value)
 * @mixin \Eloquent
 */
class OrderNote extends Model
{
    use HasDates;

    protected $table = 'order_note';
    protected $primaryKey = 'id';
    protected $fillable = ['order_id', 'user_id', 'content'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
