@extends('layouts.default')

@section('title','Checkout')
@section('body-class','checkout')

@section('content')
    <div id="checkoutApp"></div>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNN6AquuEdTY8mwR2WwzP5toj97s46Tv4&libraries=places&language=en"></script>
@endsection

@section('footer-scripts')
    <script src="{{ mix_asset('dist/web/checkout.js') }}" type="text/javascript"></script>
@endsection