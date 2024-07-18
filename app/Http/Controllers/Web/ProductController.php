<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * @return Product|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        return Product::query();
    }

    public function index(Request $request)
    {

    }

    public function show($slug)
    {
        $product = get_product($slug);
        if (!$product || !$product->isOnSale()) {
            abort(404, trans('product.this product has been removed'));
        }

//        $this->seo()->setTitle($product->title)
//            ->setDescription($product->description)
//            ->setCanonical(route('web.product.show', $product->slug))
//            ->addMeta('keywords', $product->keywords)
//            ->addMeta('og:title', $product->title)
//            ->addMeta('og:description', $product->description)
//            ->addMeta('og:url', route('web.product.show', $product->slug))
//            ->addMeta('og:image', $product->images->first()->image)
//            ->addMeta('og:site_name', settings('sitename'))
//            ->addMeta('og:locale', 'en_UK')
//            ->addMeta('og:type', 'product')
//            ->addMeta('og:modified_time', now())
//            ->addMeta('og:product:price:amount', $product->price)
//            ->addMeta('og:product:price:currency', 'EUR')
//            ->addMeta('og:product:availability', $product->isOnSale() ? 'instock' : 'outofstock')
//            ->addMeta('og:product:brand', settings('sitename'))
//            ->addMeta('og:product:category', $product->category->title)
//            ->addMeta();

        return view('web.single-product', compact('product'));
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->firstOrFail();

        $products = Product::filter([
            'category' => $category->id,
            'status' => 'onsale'
        ])->orderByDesc('sticky')->orderByDesc('sort_num')->orderByDesc('id')->paginate(50);

        return view('web.category-product', compact('category', 'products'));
    }
}
