<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasMetas;
use App\Models\Traits\HasMetaValueAttribute;
use App\Models\Traits\UserHasCarts;
use App\Models\Traits\UserHasOrders;
use App\Models\Traits\UserHasPosts;
use EloquentFilter\Filterable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * App\Models\User
 *
 * @property int $id 主键
 * @property int $gid 管理权限
 * @property string|null $nickname 昵称
 * @property string|null $email 邮箱
 * @property string|null $national_number
 * @property string|null $phone_number
 * @property string|null $avatar 头像
 * @property string|null $password 密码
 * @property string|null $remember_token
 * @property int $freeze 冻结
 * @property int $status 状态
 * @property int $points 积分
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property-read \App\Models\UserAccount|null $account
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserAddress> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $boughts
 * @property-read int|null $boughts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cart> $carts
 * @property-read int|null $carts_count
 * @property-read \App\Models\UserCertify|null $certify
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $collectedPosts
 * @property-read int|null $collected_posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserConnect> $connects
 * @property-read int|null $connects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserCreditCard> $creditCards
 * @property-read int|null $credit_cards_count
 * @property-read \Illuminate\Support\Collection $meta_data
 * @property mixed $meta_value
 * @property-read array|string|null $status_des
 * @property-read \App\Models\UserGroup|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserLog> $logs
 * @property-read int|null $logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Material> $materials
 * @property-read int|null $materials_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserMeta> $metas
 * @property-read int|null $metas_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $solds
 * @property-read int|null $solds_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserTransaction> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|User filter(array $input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFreeze($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLike(string $column, string $value, string $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNationalNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Filterable, HasApiTokens, HasDates, HasMetas;
    use UserHasPosts, UserHasOrders, UserHasCarts, HasMetaValueAttribute;

    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'gid',
        'nickname',
        'email',
        'password',
        'remember_token',
        'avatar',
        'freeze',
        'status',
        'points',
        'email_verified_at',
        'national_number',
        'phone_number'
    ];
    protected $hidden = ['password', 'remember_token', 'metas'];
    protected $appends = [
        'status_des',
        'meta_data'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function (User $user) {
            if (!$user->gid) {
                if ($group = UserGroup::orderBy('credits')->first()) {
                    $user->gid = $group->gid;
                }
            }
        });

        static::created(function (User $user) {
            $user->account()->create();
        });

        static::deleting(function (User $user) {
            $user->certify()->delete();
            $user->account()->delete();
            $user->connects()->delete();
            $user->addresses()->delete();
            $user->notifications()->delete();
            $user->transactions()->delete();
            $user->logs()->delete();
        });
    }

    /**
     * @return string|null
     */
    public function getAvatarAttribute($value)
    {
        return $value ? image_url($value) : asset('images/noodlebox/avatar.png');
    }

    /**
     * @return array|string|null
     */
    public function getStatusDesAttribute()
    {
        return is_null($this->status) ? null : trans('user.status_options.' . $this->status);
    }

    /**
     * Find the user instance for the given username.
     * @param $username
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function findForPassport($username)
    {
        return $this->where('email', $username)->first();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->getRole() == 'administrator';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(UserGroup::class, 'gid', 'gid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function connects()
    {
        return $this->hasMany(UserConnect::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function certify()
    {
        return $this->hasOne(UserCertify::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(UserLog::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|UserAccount
     */
    public function account()
    {
        return $this->hasOne(UserAccount::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materials()
    {
        return $this->hasMany(Material::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|UserAddress
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|UserTransaction
     */
    public function transactions()
    {
        return $this->hasMany(UserTransaction::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|UserMeta
     */
    public function metas()
    {
        return $this->hasMany(UserMeta::class, 'user_id', 'id');
    }

    public function updateRole($role)
    {
        $this->updateMeta('capability', $role);
    }

    public function getRole()
    {
        return $this->getMeta('capability');
    }

    public function creditCards()
    {
        return $this->hasMany(UserCreditCard::class, 'user_id', 'id');
    }
}
