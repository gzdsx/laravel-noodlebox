@extends('layouts.default')

@section('title', __('My Orders'))

@section('content')
    <section class="page-section">
        <div id="ordersApp"></div>
    </section>
@endsection

@section('footer-scripts')
    <script src="{{asset('dist/web/orders.js?v='.appversion())}}"></script>
@endsection