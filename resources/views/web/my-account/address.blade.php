@extends('web.my-account.layout')

@section('title','My Address')

@section('main-content')
    <div id="addressApp"></div>
@endsection

@section('footer-scripts')
    <script src="{{mix_asset('dist/web/my-address.js')}}"></script>
@endsection