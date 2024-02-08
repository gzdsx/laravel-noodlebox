<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function buyer(User $user, Order $order)
    {
        return $user->id == $order->buyer_id;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function seller(User $user, Order $order)
    {
        return $user->id == $order->seller_id;
    }

    /**
     * @param User $user
     * @param Order $order
     * @return bool
     */
    public function applyRefund(User $user, Order $order)
    {
        return $user->id == $order->buyer_id;
    }
}
