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

<table class="table border">
    <tbody>
    <tr>
        <th>Date</th>
        <td>{{$transaction->created_at->format('d/m/Y')}}</td>
    </tr>
    <tr>
        <th>Cashier</th>
        <td>{{optional($transaction->user)->nickname}}</td>
    </tr>
    <tr>
        <th>Float</th>
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
        <th>Total</th>
        <td>{{$transaction->total}}</td>
    </tr>
    <tr>
        <th>Net Total</th>
        <td>{{$transaction->net_total}}</td>
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