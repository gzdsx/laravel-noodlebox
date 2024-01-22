<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\Date;

class MaterialFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function q($q)
    {
        return $this->where('name', 'like', "%$q%")
            ->orWhere('url', 'like', "%$q%")
            ->orWhere('description', 'like', "%$q%");
    }

    public function user($user_id)
    {
        return $this->where('user_id', '=', $user_id);
    }

    public function type($type)
    {
        return $this->where('type', $type);
    }

    public function name($name)
    {
        return $this->where('name', 'like', "%$name%");
    }

    public function timeBegin($time)
    {
        return $this->whereDate('created_at', '>', Date::make($time));
    }

    public function timeEnd($time)
    {
        return $this->whereDate('created_at', '<', Date::make($time));
    }
}
