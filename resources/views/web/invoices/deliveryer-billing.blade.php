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
    <link href="{{mix_asset('dist/web/invoice.css')}}" rel="stylesheet" type="text/css">
</head>
<body>

<div class="header">
    <img src="{{asset('images/noodlebox/invoice-bg.jpg')}}" alt="">
</div>

<h3 class="shop-name">Noodle Box Drogheda</h3>
<h3 class="shop-name">{{optional($transaction->deliveryer)->name}}</h3>
@foreach($transaction->orders as $order)
    <table class="table" style="border: 1px solid #333;">
        <tr>
            <th>OrderN</th>
            <td>{{$order->short_code}}</td>
        </tr>
        <tr>
            <th>OrderD</th>
            <td>{{$order->created_at->format('d/m/Y H:i')}}</td>
        </tr>
        <tr>
            <th>ShippingF</th>
            <td>{{$order->shipping_total}}</td>
        </tr>
        <tr>
            <th>CostF</th>
            <td>{{$order->cost_total}}</td>
        </tr>
        <tr>
            <th>Order Total</th>
            <td>{{$order->total}}</td>
        </tr>
        <tr>
            <th>CreatedV</th>
            <td>{{$order->created_via}}</td>
        </tr>
        <tr>
            <th>PaymentS</th>
            <td>{{$order->payment_at ? 'Paid' : 'Unpaid'}}</td>
        </tr>
        <tr>
            <th>PaymentM</th>
            <td>
                @if($order->payment_method=='customize')
                    Card: {{format_amount($order->getMeta('payment_with_card_value'))}}<br>
                    Cash: {{format_amount($order->getMeta('payment_with_cash_value'))}}
                @else
                    {{$order->payment_method_title}}
                @endif
            </td>
        </tr>
        @if($order->shipping_method=='flat_rate')
            <tr>
                <th>ShippingM:</th>
                <td>{{'Delivery-'.$order->shipping_line['zone_title'] ?? ''}}</td>
            </tr>
        @else
            <tr>
                <th>ShippingM:</th>
                <td>Collection</td>
            </tr>
        @endif
        <tr>
            <th>ShippingT:</th>
            <td>{{$order->shipping['formatted_address'] ?? ''}}</td>
        </tr>
    </table>
    </table>
@endforeach

<table class="table border">
    <tbody>
    <tr>
        <th>Date</th>
        <td>{{$transaction->created_at->format('d/m/Y')}}</td>
    </tr>
    <tr>
        <th>Petrol money</th>
        <td>{{$transaction->base_amount}}</td>
    </tr>
    <tr>
        <th>Shipping Total</th>
        <td>{{$transaction->shipping_total}}</td>
    </tr>
    <tr>
        <th>Online Total</th>
        <td>{{$transaction->online_total}}</td>
    </tr>
    <tr>
        <th>Card Total</th>
        <td>{{$transaction->card_total}}</td>
    </tr>
    <tr>
        <th>Cash Total</th>
        <td>{{$transaction->cash_total}}</td>
    </tr>
    <tr>
        <th>Cost Total</th>
        <td>{{$transaction->cost_total}}</td>
    </tr>
    <tr>
        <th>Refund Total</th>
        <td>{{$transaction->refund_total}}</td>
    </tr>
    <tr>
        <th>Hand Total</th>
        <td>{{$transaction->actual_total}}</td>
    </tr>
    <tr>
        <th>Notes</th>
        <td>{{$transaction->notes}}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ucfirst($transaction->status)}}</td>
    </tr>
    </tbody>
</table>
</body>
</html>