@extends('layouts.default')

@section('title','Checkout')
@section('body-class','checkout')

@section('content')
    <div id="checkoutApp"></div>
@endsection

@section('footer-scripts')
    <script src="{{ asset('dist/web/checkout.js?v='.appversion()) }}" type="text/javascript"></script>
@endsection