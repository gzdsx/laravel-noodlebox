<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>@yield('title', 'Invoice')</title>
    <meta name="keywords" content="@yield('keywords', settings('keywords'))">
    <meta name="description" content="@yield('description', settings('description'))">
    <meta name="render" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="{{asset('dist/web/invoice.css?v='.appversion())}}" rel="stylesheet" type="text/css">
</head>
<body>

<div class="header">
    <img src="{{settings('logo')}}" alt="">
</div>

<h3 class="shop-name">Noodle Box Drogheda</h3>
<div class="shop-address">
    <p>39 West Street</p>
    <p>Drogheda</p>
    <p>Co. Louth</p>
    <p>TEL: 041-9845775</p>
    <p>www.noodlebox.ie</p>
</div>

<h1 class="title">invoice</h1>
<div class="shipping-address">
    <p>{{$order->shipping['name']}}</p>
    <p>{{$order->shipping['address']}}</p>
    @isset($order->shipping['city'])
        <p>{{$order->shipping['city'] ?? ''}}</p>
    @endisset
    @isset($order->shipping['state'])
        <p>{{$order->shipping['state'] ?? ''}}</p>
    @endisset
    @isset($order->shipping['email'])
        <p>{{$order->shipping['email'] ?? ''}}</p>
    @endisset
    @isset($order->shipping['phone'])
        <p>{{$order->shipping['phone'] ?? ''}}</p>
    @endisset
</div>
<table class="table-order-info">
    <colgroup>
        <col width="100"/>
        <col/>
    </colgroup>
    <tbody>
    <tr>
        <td>OrderN:</td>
        <td>{{$order->order_no.'@'.$order->created_at->format('H:i:s')}}</td>
    </tr>
    <tr>
        <td>OrderD:</td>
        <td>{{$order->created_at->format('m/d/Y')}}</td>
    </tr>
    <tr>
        <td>PaymentM:</td>
        <td>{{$order->payment_method_title}}</td>
    </tr>
    <tr>
        <td>ShippingM:</td>
        <td>{{$order->shipping_method==1 ? 'Collection' : 'Delivery'}}</td>
    </tr>
    </tbody>
</table>
<table class="table-order-items">
    <colgroup>
        <col/>
        <col width="100"/>
        <col width="120"/>
    </colgroup>
    <thead>
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->items as $item)
        <tr>
            <td>
                <h3 class="name">{{$item->title}}</h3>
                @if(!empty($item->meta_data))
                    <ul class="metas">
                        @foreach($item->meta_data as $meta)
                            <li>-{{$meta['value'] ?? ''}}</li>
                        @endforeach
                    </ul>
                @endif
            </td>
            <td>{{$item->quantity}}</td>
            <td>€{{$item->price}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table-total">
    <colgroup>
        <col/>
        <col width="120"/>
    </colgroup>
    <tbody>
    <tr>
        <th>Subtotal</th>
        <td>€{{$order->total}}</td>
    </tr>
    <tr>
        <th>Shipping</th>
        <td>€{{$order->shipping_total}}</td>
    </tr>
    <tr>
        <th>Total</th>
        <td>€{{$order->total}}</td>
    </tr>
    </tbody>
</table>
</body>
</html>