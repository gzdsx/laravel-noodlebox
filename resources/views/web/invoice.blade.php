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
        <col width="90"/>
        <col/>
    </colgroup>
    <tbody>
    <tr>
        <td>OrderN:</td>
        <td>{{$order->order_no}}</td>
    </tr>
    <tr>
        <td>OrderD:</td>
        <td>{{$order->created_at->format('m/d/Y H:m')}}</td>
    </tr>
    <tr>
        <td>CreatedV:</td>
        <td>{{$order->created_via}}</td>
    </tr>
    <tr>
        <td>PaymentS:</td>
        <td>
            {{$order->payment_status ? 'Paid' : 'Unpaid'}}
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
            <td>
                @if($order->shipping_line['method_id'] == 'flat_rate')
                    <span>{{$order->shipping_line['method_title'].' to '.$order->shipping_line['zone_title']}}</span>
                @else
                    <span>{{$order->shipping_line['method_title']}}</span>
                @endif
            </td>
        </tr>
    @endif
    </tbody>
</table>
<table class="table-order-items">
    <colgroup>
        <col/>
        <col width="70"/>
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
                    <div class="qty">{{$item->quantity}}</div>
                    <div style="font-weight: 400; margin-right: 3px;">x</div>
                    <div class="tit">
                        {{$item->title}}
                    </div>
                </h3>
                @if(!empty($item->meta_data))
                    @isset($item->meta_data['options'])
                        <ul class="metas">
                            @foreach($item->meta_data['options'] as $k=>$v)
                                @if(!preg_match('/None/is',$v) && !preg_match('/Original/is',$v))
                                    <li><strong>*</strong>{{$v}}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endisset
                @endif
                @if(isset($item->meta_data['purchase_via']) && $item->meta_data['purchase_via'] == 'point')
                    <small>Purchase via point</small>
                @endif
                @if(isset($item->meta_data['purchase_via']) && $item->meta_data['purchase_via'] == 'lottery')
                    <small>Purchase via lottery</small>
                @endif
            </td>
            <td class="price">{{$item->price}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@if($order->buyer_note)
    <div style="margin-top: 10px; margin-bottom: 10px; background-color: #f5f5f5; padding: 10px; border-radius: 2px;">
        <h4 style="margin: 0;">Customer Notes</h4>
        <div>{{$order->buyer_note}}</div>
    </div>
@endif
<table class="table-total">
    <colgroup>
        <col width="50%"></col>
        <col></col>
    </colgroup>
    <tbody>
    <tr>
        <th>Subtotal</th>
        <td class="text-right"><strong>€{{$subtotal}}</strong></td>
    </tr>
    <tr>
        <th>Shipping</th>
        <td class="text-right"><strong>+€{{$order->shipping_total}}</strong></td>
    </tr>
    @foreach($order->fee_lines as $fee)
        <tr>
            <th>{{$fee['name']??''}}</th>
            <td class="text-right"><strong>+€{{$fee['total']??''}}</strong></td>
        </tr>
    @endforeach
    @foreach($order->discount_lines as $discount)
        <tr>
            <th>{{$discount['name']??''}}</th>
            <td class="text-right"><strong>-€{{$discount['total']??''}}</strong></td>
        </tr>
    @endforeach
    <tr>
        <th>PaymentM</th>
        <td class="text-right" style="line-height: 1.1;">
            <strong>
                @if($order->payment_method=='customize')
                    Card: {{format_amount($order->getMeta('payment_with_card_value'))}}<br>
                    Cash: {{format_amount($order->getMeta('payment_with_cash_value'))}}
                @else
                    {{ucfirst($order->payment_method)}}
                @endif
            </strong>
        </td>
    </tr>
    <tr>
        <th>Total</th>
        <td align="right" class="text-right"><strong>€{{$order->total}}</strong></td>
    </tr>
    @if($order->getMeta('cost_total') != 0)
        <tr>
            <th>Cost Fee</th>
            <td align="right" class="text-right"><strong>€{{format_amount($order->getMeta('cost_total'))}}</strong></td>
        </tr>
    @endif
    </tbody>
</table>
<table style="width: 100%; margin-top: 20px;">
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
                @if($order->shipping_line['method_id']=='flat_rate')
                    <img src="{{asset('images/noodlebox/local-shipping.png')}}" width="75" alt="">
                @else
                    <img src="{{asset('images/noodlebox/local-pickup.png')}}" width="75" alt="">
                @endif
            </div>
            <h2 style="text-align: center; margin: 0; font-weight: bold;">{{$order->short_code}}</h2>
        </td>
    </tr>
</table>
</body>
</html>