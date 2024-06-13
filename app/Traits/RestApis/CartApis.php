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

    public function index(Request $request)
    {
        $query = $this->repository();
        if ($request->has('purchase_via')) {
            $query->where('purchase_via', $request->input('purchase_via', 0));
        }
        return json_success([
            'total' => $query->count(),
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
        $purchase_via = $request->input('purchase_via', 'order');

        $product = Product::find($product_id);
        if (isset($meta_data['purchase_with_point'])) {
            $total_points = $product->point_price * $quantity;
            if ($total_points > $request->user()->points) {
                abort(422, __('Insufficient points balance'));
            }
        }

        $key = md5(json_encode([
            $product_id,
            $meta_data
        ]));
        $cart = $this->repository()->firstOrNew(['product_id' => $product_id]);
        $cartKey = md5(json_encode([
            $cart->product_id,
            $cart->meta_data
        ]));
        if ($key == $cartKey) {
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            $cart = $this->repository()->make();
            $cart->product_id = $product->id;
            $cart->title = $product->title;
            $cart->image = $product->image;
            $cart->quantity = $quantity;
            $cart->meta_data = $meta_data;
            $cart->purchase_via = $purchase_via;
            $cart->user_id = $request->user()->id;
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
            $cart->meta_data = $request->input('meta_data', []);
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