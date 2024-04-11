<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;

class OrderFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function tab($tab)
    {
        if ($tab == 'waitPay') {
            return $this->where('order_status', 'unpaid');
        }
        if ($tab == 'waitSend') {
            return $this->where('order_status', 'paid');
        }
        if ($tab == 'waitConfirm') {
            return $this->where('order_status', 'send');
        }
        if ($tab == 'waitRate') {
            return $this->where('order_status', 'success')->where('buyer_rate', 0);
        }
        if ($tab == 'refunding') {
            return $this->where('order_status', 'refunding');
        }
        if ($tab == 'closed') {
            return $this->where('order_state', 'closed');
        }
        return $this;
    }

    public function orderNo($order_no)
    {
        return $this->where('order_no', $order_no);
    }

    public function shopName($name)
    {
        return $this->where('shop_name', 'LIKE', "%$name%");
    }

    public function product($product)
    {
        return $this->related('items', 'title', 'like', "%$product%");
    }

    public function status($status)
    {
        if ($status != 'all') {
            return $this->where('status', $status);
        }
        return $this;
    }

    public function buyerRate($rate)
    {
        return $this->where('buyer_rate', $rate);
    }

    public function sellerRate($rate)
    {
        return $this->where('seller_rate', $rate);
    }

    public function buyerName($name)
    {
        return $this->where('buyer_name', 'LIKE', "%$name%");
    }

    public function sellerName($name)
    {
        return $this->where('seller_name', 'LIKE', "%$name%");
    }

    /**
     * @param $type
     * @return OrderFilter
     */
    public function payType($type)
    {
        return $type ? $this->where('pay_type', $type) : $this;
    }

    /**
     * @param $time
     * @return OrderFilter|\Illuminate\Database\Query\Builder
     */
    public function timeBegin($time)
    {
        return $this->whereDate('created_at', '>=', Date::make($time));
    }

    /**
     * @param $time
     * @return OrderFilter|\Illuminate\Database\Query\Builder
     */
    public function timeEnd($time)
    {
        return $this->whereDate('created_at', '<=', Date::make($time));
    }
}
