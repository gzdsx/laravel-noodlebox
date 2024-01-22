<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2021 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: https://www.gzdsx.cn
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2021/3/16
 * Time: 05:21
 */

namespace App\Models\Traits;


use App\Models\Cart;
use App\Models\ProductItem;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait UserHasProduct
{
    /**
     * @return HasMany|ProductItem
     */
    public function products()
    {
        return $this->hasMany(ProductItem::class, 'seller_id', 'uid');
    }

    /**
     * @return BelongsToMany|ProductItem
     */
    public function collectedProducts()
    {
        return $this->belongsToMany(
            ProductItem::class,
            'product_collect',
            'user_id',
            'product_id',
            'uid',
            'id'
        )->as('collect')->withTimestamps()->orderBy('product_collect.created_at', 'desc');
    }
}
