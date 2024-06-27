@extends('layouts.default')

@section('title', $page->title)
@section('keywords', $page->keywords)
@section('description', $page->description)
@section('body-class','page-shop')

@php
    $category_products = category()->with(['products'=>function($builder){
            return $builder->where('status','onsale')
            ->orderByDesc('sticky')
            ->orderByDesc('sort_num')
            ->orderByDesc('created_at');
        }])->where(['taxonomy'=>'product','parent_id'=>0])
        ->whereNotIn('id',[15,221])
        ->orderBy('sort_num')->get();
@endphp
@section('content')
    <section class="swiper-container banner-swiper">
        <div class="swiper" id="bannerSwiper">
            <div class="swiper-wrapper">
                @foreach(get_block_items(1) as $image)
                    <div class="swiper-slide slide-image">
                        <a href="{{ $image->url }}">
                            <img src="{{ $image->image }}" alt="">
                        </a>
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
            new Swiper('#bannerSwiper', {
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
    <div class="shop-pc">
        <section class="page-section">
            <div class="container-fluid position-relative">
                <h5 class="text-center text-turquoise font-weight-bold">
                    What happens when fresh ingredients meet the
                    fiery theatre of the wok?
                </h5>
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

                <div class="blank-2"></div>
                <div class="product-category-tabs-container" id="productTabsPc">
                    <div class="product-category-tabs" id="tabsPC"></div>
                </div>

                <div class="product-category-tab-content" id="pcSwiper">
                    <div class="swiper-wrapper" style="overflow-y: hidden;">
                        @foreach($category_products as $category)
                            <div class="swiper-slide">
                                <div class="category-products">
                                    @foreach($category->products as $product)
                                        <div class="product-item">
                                            <div class="product-item__image">
                                                <img src="{{asset('images/noodlebox/placeholder.png')}}"
                                                     data-src="{{$product->image}}" class="absolute-fill"
                                                     alt="">
                                                @if($product->icon=='new')
                                                    <span class="product-icon product-icon__new">new!</span>
                                                @endif
                                                @if($product->icon=='hot')
                                                    <span class="product-icon product-icon__hot">hot!</span>
                                                @endif

                                                @if($product->getMeta('spicy'))
                                                    <span class="product-spicy product-spicy__{{$product->getMeta('spicy')}}"></span>
                                                @endif
                                            </div>
                                            <div class="product-item__ctx">
                                                <div class="product-item__title text-white">{{$product->title}}</div>
                                                <div class="product-item__price text-turquoise">
                                                    <bdi>€</bdi>
                                                    {{$product->price}}
                                                </div>
                                                <div>
                                                    <a class="btn btn-danger add-to-cart"
                                                       data-id="{{$product->id}}">Add
                                                        Order</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <script>
            var categories = @json($category_products);
        </script>
        <script>
            (function ($) {
                var swiperInited = false;
                new Swiper('#pcSwiper', {
                    loop: true,
                    setWrapperSize: true,
                    autoHeight: true,
                    pagination: {
                        el: '#tabsPC',
                        clickable: true,
                        bulletClass: 'category-tab',
                        bulletActiveClass: 'active',
                        renderBullet: function (index, className) {
                            return '<div class="' + className + '"> <span>' + categories[index].name + '</span></div>';
                        },
                    },
                    on: {
                        init: function () {
                            swiperInited = true;
                        },
                        slideChange: function () {
                            //console.log('slideChange');
                            if (swiperInited) {
                                $(window).scrollTop($("#bannerSwiper").height());
                            }
                        }
                    },
                });

                var tabsTop = $('#productTabsPc').offset().top;
                $(window).on('scroll', function () {
                    console.log($(window).scrollTop());
                    if ($(window).scrollTop() > (tabsTop - 104)) {
                        $('#productTabsPc').addClass('fixed');
                    } else {
                        $('#productTabsPc').removeClass('fixed');
                    }
                });
            })(jQuery)
        </script>
    </div>

    <section class="shop-mobile">
        <div class="container-fluid">
            <div class="product-category-tabs-mobile">
                <div class="cat-tabs" id="tabsMobile"></div>
            </div>
            <div class="shop-main" id="mobileSwiper">
                <div class="swiper-wrapper" style="overflow-y: hidden;">
                    @foreach($category_products as $category)
                        <div class="swiper-slide overflow-hidden">
                            <div class="product-vertical-list">
                                @foreach($category->products as $product)
                                    <div class="product-item">
                                        <div class="product-item__image">
                                            <div class="product-item__image__image">
                                                <img src="{{asset('images/noodlebox/placeholder.png')}}"
                                                     data-src="{{$product->image}}" class="absolute-fill"
                                                     alt="">
                                                @if($product->icon=='new')
                                                    <span class="product-icon product-icon__new">new!</span>
                                                @endif
                                                @if($product->icon=='hot')
                                                    <span class="product-icon product-icon__hot">hot!</span>
                                                @endif

                                                @if($spicy = $product->getMeta('spicy'))
                                                    <span class="product-spicy product-spicy__{{$spicy}}"></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-item__ctx">
                                            <div class="product-item__title text-white">{{$product->title}}</div>
                                            @if($product->getMeta('badges'))
                                                <div class="product-item__badges">
                                                    @foreach($product->getMeta('badges') as $badge)
                                                        <img src="{{$badge}}" class="badge-item" alt="">
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="product-item__price text-turquoise">
                                                    <bdi>€</bdi>
                                                    {{$product->price}}
                                                </div>
                                                <div>
                                                    <a class="btn btn-danger add-to-cart"
                                                       data-id="{{$product->id}}">Add
                                                        Order</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                (function ($) {
                    var tabEl = $('.product-category-tabs-mobile');
                    var tabsTop = tabEl.offset().top;
                    $(window).on('scroll', function () {
                        if ($(window).scrollTop() > 0) {
                            tabEl.addClass('fixed');
                        } else {
                            tabEl.removeClass('fixed');
                        }
                    });

                    var tabs = $(".cat-tabs");
                    var swiperInited = false;
                    new Swiper('#mobileSwiper', {
                        loop: true,
                        setWrapperSize: true,
                        autoHeight: true,
                        pagination: {
                            el: '#tabsMobile',
                            clickable: true,
                            bulletClass: 'cat-tab-item',
                            bulletActiveClass: 'active',
                            renderBullet: function (index, className) {
                                return '<div class="' + className + '"> <span>' + categories[index].name + '</span></div>';
                            },
                        },
                        on: {
                            init: function () {
                                swiperInited = true;
                            },
                            slideChange: function () {
                                //console.log(this.activeIndex);
                                var el = $('.cat-tabs .cat-tab-item')[this.activeIndex - 1];
                                var position = $(el).position();
                                if (position) {
                                    tabs[0].scrollLeft = tabs[0].scrollLeft + position.left - tabEl.width() / 2 + $(el).width() / 2;
                                } else {
                                    tabs[0].scrollLeft = 0;
                                }

                                if (swiperInited) {
                                    $(window).scrollTop($("#bannerSwiper").height() - tabEl.height() + $(".header-mobile").outerHeight());
                                }
                            }
                        }
                    });
                })(jQuery)
            </script>
        </div>
    </section>
@stop