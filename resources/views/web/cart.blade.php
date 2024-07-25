@extends('layouts.default')

@section('title','Cart')

@section('content')
    <section class="page-section">
        <div id="cartApp"></div>
    </section>
@endsection

@section('footer-scripts')
    <script src="{{ mix_asset('dist/web/cart.js') }}" type="text/javascript"></script>
@endsection