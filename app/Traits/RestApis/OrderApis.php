<?php

namespace App\Traits\RestApis;

use App\Models\UserPrepay;
use App\Support\TradeUtil;
use GuzzleHttp\Client;
use \Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait OrderApis
{
    /**
     * @return \App\Models\Order|Builder|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected function repository()
    {
        return Auth::user()->boughts()->withGlobalScope('avalaible', function (Builder $builder) {
            return $builder->where('buyer_deleted', 0);
        });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = $this->repository()->filter($request->all());
        $total = $query->count();
        $items = $query->offset($request->input('offset', 0))
            ->limit($request->input('limit', 10))->orderByDesc('order_id')->get();

        return json_success([
            'total' => $total,
            'items' => $items
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
    public function store(Request $request, $id = 0)
    {
        $order = $this->repository()->findOrNew($id);
        $order->order_no = TradeUtil::createOrderNo();
        $order->out_trade_no = TradeUtil::createOutTradeNo();
        $order->payment_method = $request->input('payment_method');
        $order->payment_method_title = $request->input('payment_method_title');
        $order->shipping_method = $request->input('shipping_method');
        $order->buyer_note = $request->input('buyer_note');
        $order->shipping = $request->input('shipping', []);
        $order->billing = $request->input('billing', []);

        if (Auth::check()) {
            $buyer = Auth::user();
            $order->buyer_id = $buyer->id;
            $order->buyer_name = $buyer->nickname;
        }

        $total = 0;
        $fee_lines = $request->input('fee_lines', []);
        foreach ($fee_lines as $fee_line) {
            $total += $fee_line['total'];
        }
        $order->fee_lines = $fee_lines;

        $discount_total = 0;
        $discount_lines = $request->input('discount_lines', []);
        foreach ($discount_lines as $discount_line) {
            $total -= $discount_line['total'] ?? 0;
            $discount_total += $discount_line['total'] ?? 0;
        }
        $order->discount_lines = $discount_lines;
        $order->discount_total = $discount_total;
        $order->total = $total;
        $order->save();

        $order_items = $request->input('order_items', []);
        foreach ($order_items as $order_item) {
            $order->total += $order_item['price'] * $order_item['quantity'];
            $order->items()->create($order_item);
        }
        $order->save();

        //存储地址
        $address_id = $order->shipping['id'] ?? 0;
        if (!$address_id) {
            $address = Auth::user()->addresses()->make();
            $address->fill($order->shipping);
            $address->isdefault = 1;
            $address->save();
        }

        $model = $this->repository()->find($order->order_id);
        if ($model->payment_method == 'paypal') {
            if (env('PAYPAL_ENV') == 'sandbox') {
                $auth = [
                    env('PAYPAL_SANDBOX_CLIENT_ID'),
                    env('PAYPAL_SANDBOX_CLIENT_SECRET')
                ];
                $apiUrl = 'https://api-m.sandbox.paypal.com/v1/payments/payment';
                //$apiUrl = 'https://api-m.sandbox.paypal.com/v2/checkout/orders';
            } else {
                $auth = [
                    env('PAYPAL_CLIENT_ID'),
                    env('PAYPAL_CLIENT_SECRET')
                ];
                $apiUrl = 'https://api-m.paypal.com/v1/payments/payment';
                //$apiUrl = 'https://api-m.paypal.com/v2/checkout/orders';
            }

            try {
                $client = new Client();
                $response = $client->post($apiUrl, [
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'auth' => $auth,
                    'json' => [
                        'intent' => 'sale',
                        'payer' => [
                            'payment_method' => 'paypal'
                        ],
                        'transactions' => [
                            [
                                'amount' => [
                                    'total' => $model->total,
                                    'currency' => 'EUR'
                                ]
                            ]
                        ],
                        'redirect_urls' => [
                            'return_url' => url('/payment/paypal'),
                            'cancel_url' => route('my-account')
                        ]
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                $prepay = new UserPrepay();
                $prepay->payable_id = $model->order_id;
                $prepay->payment_id = $data['id'];
                $prepay->data = $data;
                $prepay->user()->associate(Auth::id());
                $prepay->save();
                $approval_url = [$data['links'][1]['href']];

            } catch (\Exception $e) {
                return json_error($e->getMessage());
            }
        } else {
            $approval_url = [url('/order/' . $model->id)];
        }

        return json_success([
            'order' => $model,
            'approval_url' => $approval_url
        ]);
    }
}