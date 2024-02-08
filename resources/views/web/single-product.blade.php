@extends('layouts.default')

@section('title', $product->title)
@section('body-class','page-product')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="page-header">
                <h1 class="text-center">{{$product->title}}</h1>
            </div>
            <div class="page-content">
                {!! $product->content->content !!}
            </div>
        </div>
    </section>
@stop