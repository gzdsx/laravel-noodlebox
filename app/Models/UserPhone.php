<?php

namespace App\Models;

use App\Models\Traits\HasMetas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPhone
 *
 * @property int $id 主键
 * @property int $user_id 用户ID
 * @property string|null $national_number 国家代码
 * @property string|null $phone_number 电话号码
 * @property \Illuminate\Support\Carbon|null $verified_at 验证时间
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 绑定时间
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone whereNationalNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class UserPhone extends Model
{
    use HasFactory, HasMetas;

    protected $table = 'user_phone';
    protected $fillable = [
        'user_id',
        'phone_number',
        'national_number',
        'verified_at',
    ];
    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function checkPhoneNumber($user_id, $phone_number, $national_number)
    {
        if ($user_id && $phone_number && $national_number) {
            if (substr($phone_number, 0, 1) != '0') {
                $phone_number = '0' . $phone_number;
            }

            return self::where([
                'user_id' => $user_id,
                'phone_number' => $phone_number,
                'national_number' => $national_number,
            ])->exists();
        }

        return false;
    }
}
