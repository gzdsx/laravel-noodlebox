@extends('layouts.default')

@section('title', 'Checkout')
@section('body-class','checkout')

@section('content')
    <div class="container">
        <div id="checkout"></div>
    </div>
@endsection

@section('footer-scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNN6AquuEdTY8mwR2WwzP5toj97s46Tv4&libraries=places&language=en"></script>
    <script src="{{asset('dist/lottery/checkout.js?v='.appversion())}}" type="text/javascript"></script>
@endsection