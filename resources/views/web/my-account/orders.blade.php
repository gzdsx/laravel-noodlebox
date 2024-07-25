@extends('web.my-account.layout')

@section('title','My Orders')

@section('main-content')
    <div id="ordersApp"></div>
@endsection

@section('footer-scripts')
    <script src="{{mix_asset('dist/web/orders.js')}}"></script>
@endsection