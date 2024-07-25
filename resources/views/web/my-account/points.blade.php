@extends('web.my-account.layout')

@section('title','My Points')

@section('main-content')
    <div id="pointsApp"></div>
@endsection

@section('footer-scripts')
    <script src="{{mix_asset('dist/web/my-points.js')}}"></script>
@endsection