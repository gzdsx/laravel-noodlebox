<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\JPush
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $client_id
 * @property string|null $os
 * @property string|null $registerid
 * @property-read \App\Models\User|null $user
 * @method static Builder|JPush android()
 * @method static Builder|JPush ios()
 * @method static Builder|JPush newModelQuery()
 * @method static Builder|JPush newQuery()
 * @method static Builder|JPush query()
 * @method static Builder|JPush whereClientId($value)
 * @method static Builder|JPush whereId($value)
 * @method static Builder|JPush whereOs($value)
 * @method static Builder|JPush whereRegisterid($value)
 * @method static Builder|JPush whereUserId($value)
 * @mixin \Eloquent
 */
class JPush extends Model
{
    protected $table = 'jpush';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'appid', 'platform', 'registrationid'];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uid');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeIos(Builder $builder)
    {
        return $builder->where('platform', 'ios');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeAndroid(Builder $builder)
    {
        return $builder->where('platform', 'android');
    }
}
