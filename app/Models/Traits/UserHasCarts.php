<?php

namespace App\Models\Traits;

use App\Models\Cart;

trait UserHasCarts
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Cart
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }
}