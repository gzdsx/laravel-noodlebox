<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\HasImageAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Deliveryer
 *
 * @property int $id 主键
 * @property string|null $name 配送员姓名
 * @property string|null $phone 配送员电话
 * @property string $image 照片
 * @property float $lng 当前位置
 * @property float $lat 当前位置
 * @property string|null $pos pos机
 * @property string|null $status 状态
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer wherePos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deliveryer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Deliveryer extends Model
{
    use HasFactory, HasImageAttribute, HasDates;

    protected $table = 'deliveryer';
    protected $fillable = [
        'name',
        'phone',
        'image',
        'status',
        'lng',
        'lat',
    ];
}
