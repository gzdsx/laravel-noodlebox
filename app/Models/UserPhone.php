<?php

namespace App\Models;

use App\Models\Traits\HasMetas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserPhone
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $national_number
 * @property string|null $phone_number
 * @property int $verified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|UserPhone whereVerified($value)
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
        'verified',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
