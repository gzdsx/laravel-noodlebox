<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Captcha
 *
 * @property int $id
 * @property string|null $code 验证码
 * @property string|null $phone 手机号
 * @property string|null $email 邮箱
 * @property \Illuminate\Support\Carbon|null $created_at 发送时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha query()
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Captcha whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Captcha extends Model
{
    protected $table = 'captcha';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'phone', 'email', 'used'];

    /**
     * @param $phone
     * @param $code
     * @return bool
     */
    public static function checkPhone($phone, $code)
    {
        $phone = preg_replace('/\s/', '', $phone);
        if ($captcha = static::where('code', $code)->orderByDesc('id')->first()) {
            return $captcha->phone == $phone;
        }

        return false;
    }
}
