<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCreditCard
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name 名称
 * @property string|null $card_no 卡号
 * @property string|null $expiration 有效期
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property \Illuminate\Support\Carbon|null $last_use_at 最后使用时间
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard whereCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard whereLastUseAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserCreditCard whereUserId($value)
 * @mixin \Eloquent
 */
class UserCreditCard extends Model
{
    use HasFactory, HasDates;

    protected $table = 'user_credit_card';
    protected $fillable = [
        'user_id',
        'name',
        'card_no',
        'expiration',
        'last_use_at'
    ];
    protected $dates = ['last_use_at'];
}
