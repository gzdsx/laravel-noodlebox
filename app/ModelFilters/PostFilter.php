<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Date;

class PostFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * @param $q
     * @return PostFilter
     */
    public function q($q)
    {
        return $this->where('title', 'LIKE', "%$q%");
    }

    public function title($title)
    {
        return $this->where('title', 'LIKE', "%$title%");
    }

    /**
     * @param $username
     * @return PostFilter|Builder
     */
    public function nickname($name)
    {
        return $this->related('user', 'nickname', 'LIKE', "%$name%");
    }

    /**
     * @param $cate
     * @return PostFilter
     */
    public function cate($cate)
    {
        if ($cate) {
            return $this->related('categories', 'cate_id', '=', $cate);
        }

        return $this;
    }

    /**
     * @param $status
     * @return $this|PostFilter
     */
    public function status($status)
    {
        if ($status !== 'all') {
            return $this->where('status', $status);
        }
        return $this;
    }

    public function format($format)
    {
        return $this->where('format', $format);
    }

    /**
     * @param $type
     * @return PostFilter
     */
    public function type($type)
    {
        return $this->where('type', $type);
    }

    /**
     * @param $time
     * @return $this|PostFilter
     */
    public function timeBegin($time)
    {
        return $this->whereDate('created_at', '>=', now($time));
    }

    /**
     * @param $time
     * @return $this|PostFilter
     */
    public function timeEnd($time)
    {
        return $this->whereDate('created_at', '<=', now($time));
    }

    /**
     * @param $sort
     * @return PostFilter
     */
    public function sort($sort)
    {
        if ($sort == 'time-desc') {
            return $this->orderByDesc('created_at');
        }

        if ($sort == 'views-desc') {
            return $this->orderByDesc('views');
        }

        if ($sort == 'id-asc') {
            return $this->orderBy('id');
        }

        return $this->orderByDesc('id');
    }
}
