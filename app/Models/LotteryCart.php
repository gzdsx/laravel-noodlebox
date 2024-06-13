<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LotteryCart
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $image
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart query()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryCart whereUserId($value)
 * @mixin \Eloquent
 */
class LotteryCart extends Model
{
    use HasFactory, HasDates;

    protected $table = 'lottery_cart';
    protected $fillable = ['user_id', 'name', 'image', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
