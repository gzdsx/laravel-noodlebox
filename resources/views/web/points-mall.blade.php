@extends('layouts.default')

@section('title','Points Mall')
@section('body-class','points-mall')
@section('og-type','page')

@section('content')
    <div class="page-section">
        <div class="container">
            <div class="row flex-column flex-md-row">
                <div class="col col-md-3">
                    <h2 class="font-weight-normal">
                        <a href="{{url('points-mall')}}" class="text-safety-orange">Points Mall</a>
                    </h2>
                    <ul class="points-mall-tags">
                        @foreach($tags as $tag)
                            <li class="tag-item">
                                <a href="{{route('points-mall',['tag'=>$tag])}}"
                                   class="tag-link-{{$loop->index}}">{{$tag}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col col-md-9">
                    <div class="product-list">
                        @foreach($products as $prod)
                            <div class="product-item">
                                <div class="product-item__image">
                                    <a href="{{$prod->url}}" title="{{$prod->title}}">
                                        <img src="{{asset('images/noodlebox/placeholder.png')}}" data-src="{{$prod->image}}" alt="{{$prod->title}}"/>
                                    </a>
                                </div>
                                <div class="product-item__title">
                                    <a href="{{$prod->url}}">
                                        {{$prod->title}}
                                    </a>
                                </div>
                                <div class="product-item__price">€{{$prod->price}}</div>
                                <div class="product-item__add-order">
                                    <a class="btn btn-danger add-to-cart" data-id="{{$prod->id}}">Add Order</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection