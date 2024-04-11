<?php
/**
 * @return \App\Models\Product|\Illuminate\Database\Eloquent\Builder
 */
function product_query()
{
    return \App\Models\Product::query();
}

/**
 * @param $id
 * @return \App\Models\Product|\App\Models\Product[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|object|null
 */
function get_product($id)
{
    $query = product_query();
    if (preg_match('/^\d+$/', $id)) {
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
    $filters = array_merge([
        'status' => 'onsale'
    ], $options);
    $query = \App\Models\Product::filter($filters);
    if (isset($filters['limit'])) {
        $query->offset($filters['offset'] ?? 0)->limit($filters['limit']);
    }

    $orderBy = $options['orderby'] ?? 'id';
    $order = $options['order'] ?? 'desc';

    return $query->orderBy($orderBy, $order)->get();
}