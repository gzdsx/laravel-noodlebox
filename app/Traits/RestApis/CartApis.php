<?php

namespace App\Traits\RestApis;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait CartApis
{
    /**
     * @return Cart|\Illuminate\Database\Eloquent\Builder
     */
    protected function repository()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
        } else {
            $user_id = md5(session()->getId());
        }

        return Cart::withGlobalScope('owner', function ($builder) use ($user_id) {
            return $builder->where('user_id', $user_id);
        });
    }

    public function index()
    {
        $query = $this->repository();
        return json_success([
            'count' => $query->count(),
            'items' => $query->get()
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository()->findOrFail($id);
        return json_success($model);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $product_id = $request->input('product_id', 0);
        $quantity = $request->input('quantity', 1);
        $meta_data = $request->input('meta_data', []);
        $meta_price = array_reduce($meta_data, function ($carry, $item) {
            return $carry + $item['price'];
        }, 0);

        $product = Product::find($product_id);
        $price = $product->price + $meta_price;

        $cart = $this->repository()->where('product_id', $product_id)->firstOrNew();
        if (json_encode($cart->meta_data) == json_encode($meta_data)) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            $cart->product_id = $product->id;
            $cart->title = $product->title;
            $cart->image = $product->image;
            $cart->price = $price;
            $cart->quantity = $quantity;
            $cart->meta_data = $meta_data;
            $cart->user_id = Auth::check() ? Auth::id() : md5(session()->getId());
            $cart->save();
        }

        $cart->refresh();
        return json_success($cart);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $cart = $this->repository()->findOrNew($id);
        if (!$cart->product) {
            $cart->delete();
            abort(404, 'product no found');
        }

        if ($request->has('quantity')) {
            $cart->quantity = $request->input('quantity', 1);
        }

        if ($request->has('meta_data')) {
            $meta_data = $request->input('meta_data', []);
            $meta_price = array_reduce($meta_data, function ($carry, $item) {
                return $carry + $item['price'];
            }, 0);
            $cart->price = $cart->product->price + $meta_price;
        }

        $cart->save();
        return json_success($cart);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->repository()->whereKey($id)->delete();
        return json_success();
    }
}