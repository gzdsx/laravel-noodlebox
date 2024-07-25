@extends('layouts.default')

@section('title', $product->title)
@section('keywords', $product->keywords)
@section('description', strip_tags($product->description))
@section('body-class','single-product')

@section('scripts')
    <script>
        window.g_config = {
            productId: {{$product->id}},
        }
    </script>
@endsection

@section('content')
    <div class="d-none">
        <h1>{{$product->title}}</h1>
        <div class="price">price:{{$product->price}}</div>
        <div class="description">{!! $product->description !!}</div>
    </div>
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-9">
                    <div class="row">
                        <div class="col col-md-6">
                            <div class="swiper product-swiper">
                                <div class="swiper-wrapper">
                                    @foreach($product->images as $image)
                                        <div class="swiper-slide">
                                            <div class="product-slide-image">
                                                <img src="{{$image->image}}" alt="{{$product->title}}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
                            <div class="swiper product-thumbnails">
                                <div class="swiper-wrapper">
                                    @foreach($product->images as $image)
                                        <div class="swiper-slide">
                                            <img src="{{$image->image}}" alt="{{$product->title}}"/>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <script>
                                (function () {
                                    var swiper = new Swiper('.product-thumbnails', {
                                        loop: true,
                                        spaceBetween: 10,
                                        slidesPerView: 5,
                                        freeMode: true,
                                        watchSlidesProgress: true,
                                    });

                                    new Swiper(".product-swiper", {
                                        loop: true,
                                        spaceBetween: 10,
                                        navigation: {
                                            nextEl: ".swiper-button-next",
                                            prevEl: ".swiper-button-prev",
                                        },
                                        thumbs: {
                                            swiper: swiper,
                                        },
                                    });
                                })();
                            </script>
                        </div>
                        <div class="col col-md-6 mt-4 mt-md-0">
                            <div id="productMetas"></div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-3 side-right">
                    @include('web.product-right')
                </div>
            </div>
        </div>
        <div class="blank-2"></div>
        <div class="container">
            <h3>Related Products</h3>
            <div class="product-list product-related-products">
                @foreach(get_products(['category'=>$product->categories->pluck('id')->toArray(),'limit'=>6]) as $prod)
                    <div class="product-item">
                        <div class="product-item__image">
                            <a href="{{$prod->url}}" title="{{$prod->title}}">
                                <img src="{{asset('images/noodlebox/placeholder.png')}}" data-src="{{$prod->image}}"
                                     alt="{{$prod->title}}"/>
                            </a>
                            @if($prod->icon=='new')
                                <span class="product-icon product-icon__new">new!</span>
                            @endif
                            @if($prod->icon=='hot')
                                <span class="product-icon product-icon__hot">hot!</span>
                            @endif

                            @if($prod->getMeta('spicy'))
                                <span class="product-spicy product-spicy__{{$product->getMeta('spicy')}}"></span>
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
    </section>
@stop

@section('footer-scripts')
    <script src="{{ mix_asset('dist/web/product.js') }}" type="text/javascript"></script>
@endsection