<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LotteryRecord
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $title
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotteryRecord whereUserId($value)
 * @mixin \Eloquent
 */
class LotteryRecord extends Model
{
    use HasFactory, HasDates;

    protected $table = 'lottery_record';
    protected $fillable = ['user_id', 'title', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
