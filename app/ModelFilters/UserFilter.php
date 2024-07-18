<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\Date;

class UserFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function id($id)
    {
        return $this->where('id', '=', $id);
    }

    public function nickname($name)
    {
        return $this->where('nickname', 'like', "%$name%");
    }

    public function phone($phone)
    {
        return $this->where('phone', '=', $phone);
    }

    public function email($email)
    {
        return $this->where('email', '=', $email);
    }

    public function gid($gid)
    {
        return $this->where('gid', $gid);
    }

    public function timeBegin($time)
    {
        return $this->whereDate('created_at', '>=', Date::make($time));
    }

    public function timeEnd($time)
    {
        return $this->whereDate('created_at', '<=', Date::make($time));
    }

    public function status($status)
    {
        if ($status == 'forbidden') {
            return $this->where('freeze', 1);
        }

        return $this;
    }

    public function role($role)
    {
        if ($role == 'administrator' || $role == 'manager') {
            return $this->whereHas('metas', function ($query) use ($role) {
                return $query->where('meta_key', 'capability')->where('meta_value', $role);
            });
        }

        return $this->whereHas('metas', function ($query) use ($role) {
            return $query->where('meta_key', 'capability')->where('meta_value', $role);
        })->orDoesntHave('metas');
    }
}
