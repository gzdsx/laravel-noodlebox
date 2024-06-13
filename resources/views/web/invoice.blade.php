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
    <img src="{{asset('images/noodlebox/invoice-bg.jpg')}}" alt="">
</div>

<h3 class="shop-name">Noodle Box Drogheda</h3>
<table style="width: 100%;">
    <tr>
        <td>
            <div class="shop-address">
                <p>39 West Street</p>
                <p>Drogheda</p>
                <p>Co. Louth</p>
                <p>TEL: 041-9845775</p>
                <p>www.noodlebox.ie</p>
            </div>
        </td>
        <td style="width: 100px; text-align: center;">
            <div>
                @if($order->shipping_method=='delivery')
                    <img src="{{asset('images/noodlebox/local-shipping.png')}}" width="80" alt="">
                @else
                    <img src="{{asset('images/noodlebox/local-pickup.png')}}" width="80" alt="">
                @endif
            </div>
            <h2 style="text-align: center; margin: 0; font-weight: bold;">{{$order->short_code}}</h2>
        </td>
    </tr>
</table>

<h1 class="title">invoice</h1>
<div class="shipping-address">
    <p>{{$order->shipping['first_name'] ?? ''}}</p>
    <p>{{$order->shipping['address_line_1'] ?? ''}}</p>
    @isset($order->shipping['city'])
        <p>{{$order->shipping['city'] ?? ''}}</p>
    @endisset
    @isset($order->shipping['state'])
        <p>{{$order->shipping['state'] ?? ''}}</p>
    @endisset
    @isset($order->shipping['postal_code'])
        <p>{{$order->shipping['postal_code'] ?? ''}}</p>
    @endisset
    @isset($order->shipping['email'])
        <p>{{$order->shipping['email'] ?? ''}}</p>
    @endisset
    @isset($order->shipping['phone'])
        @if(is_array($order->shipping['phone']))
            <p>
                <span>+{{$order->shipping['phone']['national_number'] ?? ''}}</span>
                <span>{{$order->shipping['phone']['phone_number'] ?? ''}}</span>
            </p>
        @else
            <p>{{$order->shipping['phone'] ?? ''}}</p>
        @endif
    @endisset
</div>
<table class="table-order-info">
    <colgroup>
        <col width="110"/>
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
        <td>Created Via:</td>
        <td>{{$order->created_via}}</td>
    </tr>
    <tr>
        <td>PaymentM:</td>
        <td>
            @if($order->payment_method=='paypal')
                Pay Online
            @elseif($order->payment_method=='cash')
                Pay Cash
            @else
                Pay by Card Reader
            @endif
        </td>
    </tr>
    @if($order->shipping_method=='delivery')
    <tr>
        <td>ShippingM:</td>
        <td>{{ucfirst($order->shipping_method)}}-{{$order->shippingZone->title}}</td>
    </tr>
    @else
        <tr>
            <td>ShippingM:</td>
            <td>{{ucfirst($order->shipping_method)}}</td>
        </tr>
    @endif
    </tbody>
</table>
<table class="table-order-items">
    <colgroup>
        <col/>
        <col width="120"/>
    </colgroup>
    <thead>
    <tr>
        <th>Product</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order_items as $item)
        <tr>
            <td>
                <h3 class="name">
                    {{$item->quantity}}<sub style="line-height: 1; vertical-align: -2px;">&#42;</sub>{{$item->title}}
                </h3>
                @if(!empty($item->meta_data))
                    @isset($item->meta_data['options'])
                        <ul class="metas">
                            @foreach($item->meta_data['options'] as $k=>$v)
                                <li>-{{$v}}</li>
                            @endforeach
                        </ul>
                    @endisset
                @endif
            </td>
            <td>€{{$item->price}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<table class="table-total">
    <colgroup>
        <col width="50%"/>
        <col/>
        <col width="120"/>
    </colgroup>
    <tbody>
    <tr>
        <th></th>
        <th>Subtotal</th>
        <td><strong>€{{$subtotal}}</strong></td>
    </tr>
    <tr>
        <th></th>
        <th>Shipping</th>
        <td><strong>€{{$order->shipping_total}}</strong></td>
    </tr>
    @foreach($order->fee_lines as $fee)
        <tr>
            <th></th>
            <th>{{$fee['name']??''}}</th>
            <td><strong>€{{$fee['total']??''}}</strong></td>
        </tr>
    @endforeach
    <tr>
        <th></th>
        <th>Total</th>
        <td><strong>€{{$order->total}}</strong></td>
    </tr>
    </tbody>
</table>
@if($order->buyer_note)
    <div style="margin-top: 30px; background-color: #f5f5f5; padding: 10px; border-radius: 2px;">
        {{$order->buyer_note}}
    </div>
@endif
</body>
</html>