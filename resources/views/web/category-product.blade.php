@extends('layouts.default')

@section('title',$category->name)
@section('og-type','category')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-9">
                    <h2 class="text-center">{{$category->name}}</h2>
                    <div class="product-list">
                        @foreach($products as $prod)
                            <div class="product-item">
                                <div class="product-item__image">
                                    <a href="{{$prod->url}}" title="{{$prod->title}}">
                                        <img src="{{asset('images/noodlebox/placeholder.png')}}" data-src="{{$prod->image}}" alt="{{$prod->title}}"/>
                                    </a>
                                    @if($prod->icon=='new')
                                        <span class="product-icon product-icon__new">new!</span>
                                    @endif
                                    @if($prod->icon=='hot')
                                        <span class="product-icon product-icon__hot">hot!</span>
                                    @endif

                                    @if($spicy = $prod->getMeta('spicy'))
                                        <span class="product-spicy product-spicy__{{$spicy}}"></span>
                                    @endif
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
                <div class="col col-md-3 side-right">
                    @include('web.product-right')
                </div>
            </div>
        </div>
    </section>
@endsection