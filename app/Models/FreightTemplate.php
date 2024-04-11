<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\FreightTemplate
 *
 * @property int $id 模板ID
 * @property int $shop_id 店铺ID
 * @property string|null $template_name 模板名称
 * @property string|null $template_info 描述
 * @property int $valuation 计价方式
 * @property int $start_quantity 默认数量
 * @property string $start_fee 默认运费
 * @property int $growth_quantity 递增数量
 * @property string $growth_fee 递增运费
 * @property string|null $delivery_areas 配送区域
 * @property string $free_amount 包邮金额
 * @property int $free_quantity 包邮数量
 * @property-read \App\Models\Shop|null $shop
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereDeliveryAreas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereFreeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereFreeQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereGrowthFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereGrowthQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereStartFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereStartQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereTemplateInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereTemplateName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FreightTemplate whereValuation($value)
 * @mixin \Eloquent
 */
class FreightTemplate extends Model
{
    protected $table = 'freight_template';
    protected $primaryKey = 'id';
    protected $fillable = [
        'shop_id', 'template_name', 'template_info', 'valuation', 'start_quantity',
        'start_fee', 'growth_quantity', 'growth_fee', 'delivery_areas', 'free_amount', 'free_quantity'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }
}
