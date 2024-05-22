<?php

namespace App\ModelFilters;


use App\Models\Product;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function cat($cat)
    {
        if ($cat) {
            if (is_array($cat)) {
                $cats = $cat;
            } else {
                $cats = explode(',', $cat);
            }

            return $this->whereHas('categories', function (Builder $builder) use ($cats) {
                return $builder->whereIn('id', $cats);
            });
        }
        return $this;
    }

    public function category($cat)
    {
        if ($cat) {
            if (is_array($cat)) {
                $cats = $cat;
            } else {
                $cats = explode(',', $cat);
            }

            return $this->whereHas('categories', function (Builder $builder) use ($cats) {
                return $builder->whereIn('category.id', $cats);
            });
        }
        return $this;
    }

    /**
     * @param $q
     * @return ProductFilter
     */
    public function q($q)
    {
        return $this->where('title', 'like', "%$q%");
    }

    /**
     * @param $tag
     * @return ProductFilter
     */
    public function tag($tag)
    {
        return $this->where('keywords', 'like', "%$tag%");
    }

    /**
     * @param $uid
     * @return ProductFilter
     */
    public function user($user_id)
    {
        return $this->where('user_id', $user_id);
    }

    /**
     * @param $state
     * @return $this
     */
    public function status($status)
    {
        if ($status !== 'all') {
            return $this->where('status', $status);
        }
        return $this;
    }

    /**
     * @param $title
     * @return ProductFilter
     */
    public function title($title)
    {
        return $this->where('title', 'LIKE', "%$title%");
    }

    /**
     * @param $price
     * @return ProductFilter
     */
    public function minPrice($price)
    {
        return $this->where('price', '>', floatval($price));
    }

    /**
     * @param $price
     * @return $this|ProductFilter
     */
    public function maxPrice($price)
    {
        return $this->where('price', '<', floatval($price));
    }

    /**
     * @param $itemid
     * @return ProductFilter
     */
    public function product($product)
    {
        return $this->where('id', $product);
    }

    /**
     * @param $sort
     * @return $this|ProductFilter
     */
    public function sort($sort)
    {
        $builder = $this->orderByDesc('sticky')->orderByDesc('sort_num');
        if ($sort == 'sale-asc') {
            return $builder->orderBy('sold');
        }

        if ($sort == 'sale-desc') {
            return $builder->orderByDesc('sold');
        }

        if ($sort == 'price-asc') {
            return $builder->orderBy('price');
        }

        if ($sort == 'price-desc') {
            return $builder->orderByDesc('price');
        }

        return $builder->orderByDesc('id');
    }

    /**
     * @param $tab
     * @return $this|ProductFilter
     */
    public function tab($tab)
    {
        if ($tab == 'forsale') {
            return $this->where('status', Product::STAUTS_FORSALE);
        }

        if ($tab == 'offsale') {
            return $this->where('status', Product::STAUTS_OFFSALE);
        }

        if ($tab == 'soldout') {
            return $this->where('status', Product::STAUTS_SOLDOUT);
        }
        return $this;
    }
}
