@extends('layouts.default')

@section('title','Cart')

@section('content')
    <section class="page-section">
        <div id="cartApp"></div>
    </section>
@endsection

@section('footer-scripts')
    <script src="{{ asset('dist/web/cart.js?v='.appversion()) }}" type="text/javascript"></script>
@endsection