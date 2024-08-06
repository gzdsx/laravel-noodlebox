<?php namespace App\ModelFilters;

use App\Models\Order;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
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
            return $this->where('status', Order::STATUS_PENDING);
        }
        if ($tab == 'waitSend') {
            return $this->where('status', Order::STATUS_PROCESSIING);
        }
        if ($tab == 'waitConfirm') {
            return $this->where('status', Order::STATUS_DELIVERING);
        }
        if ($tab == 'waitRate') {
            return $this->where('status', 'success')->where('buyer_rate', 0);
        }
        if ($tab == 'refunding') {
            return $this->where('status', 'refunding');
        }
        if ($tab == 'closed') {
            return $this->where('status', 'closed');
        }
        return $this;
    }

    public function orderNo($order_no)
    {
        return $this->where('order_no', $order_no)->orWhere('short_code', $order_no);
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
    public function timeStart($time)
    {
        return $this->where('created_at', '>=', $time);
    }

    /**
     * @param $time
     * @return OrderFilter|\Illuminate\Database\Query\Builder
     */
    public function timeEnd($time)
    {
        return $this->where('created_at', '<=', $time);
    }

    public function date($date)
    {
        $date = substr($date, 0, 10);
        $start = Carbon::createFromTimeString($date . ' ' . settings('opening_hours_end'));
        $end = Carbon::createFromTimeString($date . ' ' . settings('opening_hours_start'))->addDay();
        return $this->whereBetween('created_at', [$start, $end]);
    }

    public function deliveryer($deliveryer)
    {
        return $this->where('deliveryer_id', $deliveryer);
    }

    public function createdVia($via)
    {
        return $this->where('created_via', $via);
    }

    public function paymentMethod($method)
    {
        return $this->where('payment_method', $method);
    }
}
