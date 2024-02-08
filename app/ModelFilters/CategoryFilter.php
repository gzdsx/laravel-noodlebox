<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class CategoryFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function taxonomy($taxonomy)
    {
        return $this->where('taxonomy', $taxonomy);
    }

    public function parent($parent)
    {
        return $this->where('parent_id', $parent);
    }

    public function relations($relations)
    {
        return $this->with($relations);
    }

    /**
     * @param $exclude
     * @return CategoryFilter
     */
    public function excludes($exclude)
    {
        if (is_array($exclude)) {
            $excludes = $exclude;
        } else {
            $excludes = explode(',', $exclude);
        }

        return $this->whereNotIn('id', $excludes);
    }

    /**
     * @param $include
     * @return CategoryFilter
     */
    public function includes($include)
    {
        if (is_array($include)){
            $includes = $include;
        } else {
            $includes = explode(',', $include);
        }

        return $this->whereIn('id', $includes);
    }
}
