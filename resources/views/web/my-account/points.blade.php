@extends('web.my-account.layout')

@section('title','My Points')

@section('main-content')
    <div id="pointsApp"></div>
@endsection

@section('footer-scripts')
    <script src="{{asset('dist/web/my-points.js?v='.appversion())}}"></script>
@endsection