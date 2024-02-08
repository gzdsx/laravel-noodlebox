<?php
/**
 * @param $id
 * @return \App\Models\Product|\App\Models\Product[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|object|null
 */
function get_product($id)
{
    $query = \App\Models\Product::query();

    if (preg_match('/\d+/', $id)) {
        return $query->find($id);
    } else {
        return $query->where('slug', $id)->first();
    }
}

/**
 * @param $options
 * @return \App\Models\Product[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
 */
function get_products($options = [])
{
    $query = \App\Models\Product::filter($options);
    $query->offset($options['offset'] ?? 0);
    $query->limit($options['limit'] ?? 15);

    $orderBy = $options['orderby'] ?? 'id';
    $order = $options['order'] ?? 'desc';

    return $query->orderBy($orderBy, $order)->get();
}