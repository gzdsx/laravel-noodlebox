<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LotterySetting
 *
 * @property string $skey
 * @property string|null $svalue
 * @method static \Illuminate\Database\Eloquent\Builder|LotterySetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotterySetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LotterySetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|LotterySetting whereSkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LotterySetting whereSvalue($value)
 * @mixin \Eloquent
 */
class LotterySetting extends Model
{
    protected $table = 'lottery_settings';
    protected $fillable = ['skey', 'svalue'];
    protected $primaryKey = 'skey';
    protected $keyType = 'string';

    public $timestamps = false;

    public function getSvalueAttribute($value)
    {
        $v = json_decode($value, true);
        if (is_array($v)) {
            return $v;
        }

        return $value;
    }

    public function setSvalueAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['svalue'] = json_encode($value);
        } else {
            $this->attributes['svalue'] = $value;
        }
    }
}
