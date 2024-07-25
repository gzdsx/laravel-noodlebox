<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class PointsMallController extends BaseController
{
    public function index(Request $request, $slug = null)
    {
        $points_mall_categories = get_categories(['parent' => 221]);
        if ($slug) {
            $category = Category::where(['slug' => $slug, 'taxonomy' => 'product'])->first();
        } else {
            $category = $points_mall_categories->first();
        }

        $products = get_products(['category' => $category->id]);
        return view('web.points-mall', compact('products', 'points_mall_categories'));
    }
}
