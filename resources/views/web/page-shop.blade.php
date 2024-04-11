@extends('layouts.default')

@section('title', $page->title)
@section('keywords', $page->keywords)
@section('description', $page->description)
@section('body-class','page-shop')

@section('content')
    <section class="swiper-container banner-swiper">
        <div class="swiper" id="bannerSwiper">
            <div class="swiper-wrapper">
                @foreach(get_block_items(1) as $image)
                    <div class="swiper-slide slide-image">
                        <img src="{{ $image->image }}" alt="">
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>
    <script>
        (function () {
            var swiper = new Swiper('#bannerSwiper', {
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false
                },
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            });
        })()
    </script>

    @php
        $products = cache()->rememberForever('front-products',function (){
            return get_products(['status'=>'onsale','limit'=>1000])->groupBy(function ($item,$key){
                if ($item->categories->count() > 0){
                    return $item->categories->first()->id;
                }else{
                    return 0;
                }
            });
        });
    @endphp
    <section class="page-section">
        <div class="container-fluid">
            <h5 class="text-center text-turquoise font-weight-bold">What happens when fresh ingredients meet the fiery
                theatre of the wok?</h5>
            <div class="product-category-circles">
                @foreach($categories as $category)
                    <div class="category-item">
                        <div class="category-item__icon">
                            <a href="{{$category->url}}">
                                <img src="{{$category->image}}" alt="">
                            </a>
                        </div>
                        <div class="category-item__title">{{$category->name}}</div>
                    </div>
                @endforeach
            </div>
            <div class="product-category-tabs">
                @foreach($categories as $category)
                    <div class="category-tab{{$loop->index==0 ? ' category-tab__active' : ''}}">
                        <span>{{$category->name}}</span>
                    </div>
                @endforeach
            </div>

            <div class="product-category-tab-content">
                @foreach($categories as $category)
                    <div class="product-category-tab-panel">
                        <div class="category-products">
                            @if(isset($products[$category->id]))
                                @foreach($products[$category->id] as $product)
                                    <div class="product-item">
                                        <div class="product-item__image">
                                            <a href="{{$product->url}}">
                                                <img src="{{asset('images/noodlebox/placeholder.png')}}" data-src="{{$product->image}}" class="absolute-fill" alt="">
                                            </a>
                                        </div>
                                        <div class="product-item__ctx">
                                            <div class="product-item__title text-white">{{$product->title}}</div>
                                            <div class="product-item__price text-turquoise">
                                                <bdi>€</bdi>
                                                {{$product->price}}
                                            </div>
                                            <div>
                                                <a class="btn btn-danger add-to-cart" data-id="{{$product->id}}">Add Order</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <script>
        (function ($) {
            $(".category-tab").on('click',function () {
                $(this).addClass('category-tab__active').siblings().removeClass('category-tab__active');
                $(".product-category-tab-panel").eq($(this).index()).show().siblings().hide();
            })
        })(jQuery)
    </script>
@stop