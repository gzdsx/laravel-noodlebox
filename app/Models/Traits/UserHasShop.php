<?php

namespace App\Models\Traits;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait UserHasShop
{
    /**
     * @return HasOne|Shop
     */
    public function shop()
    {
        return $this->hasOne(Shop::class, 'seller_id', 'uid');
    }

    /**
     * @return BelongsToMany|Shop
     */
    public function subscribedShops()
    {
        return $this->belongsToMany(
            Shop::class,
            'shop_subscribe',
            'user_id',
            'shop_id',
            'uid',
            'shop_id'
        )->as('subscribes')->withTimestamps();
    }
}