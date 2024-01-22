@extends('layouts.default')

@section('body-class','home')

@section('content')
    <div class="swiper-container home-swiper">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach(get_block_items(1) as $k=>$item)
                    <div class="swiper-slide">
                        <a href="{{$item->url}}"><img src="{{$item->image}}" alt=""></a>
                        <div class="slide-text-box slide-text-{{$k%3}}">
                            <h1><a href="{{$item->url}}">{{$item->title}}</a></h1>
                            <p class="text-break">{{$item->description}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <script>
        (function ($) {
            new Swiper('.swiper', {
                effect: "fade",
                loop: true,
                autoplay: true,
                speed: 2000,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            });
        })(jQuery);
    </script>

    <div class="home-about">
        <div class="container">
            <p>
                {!! snippet(1)->content !!}
            </p>
            <h2><a href="{{url('about-us')}}" class="text-tiffany-blue">Learn More</a></h2>
        </div>
    </div>

    <div class="home-block home-what-we-do">
        <div class="container">
            <div class="row flex-column flex-md-row">
                <div class="col col-md-3">
                    <h1>
                        What
                        <span class="what-sp"></span>
                        We Do
                    </h1>
                </div>
                <div class=" col col-md-9">
                    <div class="row-service">
                        <div class="col-main">
                            <h1>Real Estate Full Services</h1>
                        </div>
                        <div class="col-right">
                            <p class="text-muted text-size-md">
                                We offer comprehensive real estate services, seamlessly guiding clients through buying,
                                selling,
                                leasing, and property management processes with a commitment to personalized excellence
                                at every
                                step.
                            </p>
                            <a href="{{url('services')}}" class="sliding-link text-size-md font-weight-bold">
                                Explore Services
                            </a>
                        </div>
                    </div>

                    <div class="row-service">
                        <div class="col-main">
                            <h1>Investment</h1>
                        </div>
                        <div class="col-right">
                            <p class="text-muted text-size-md">
                                We provide strategic guidance and expert insights, empowering clients to make informed
                                real
                                estate investment decisions and optimize their portfolios for long-term success.
                            </p>
                            <a href="{{url('services')}}" class="sliding-link text-size-1 font-weight-bold">
                                Explore Services
                            </a>
                        </div>
                    </div>

                    <div class="row-service">
                        <div class="col-main">
                            <h1>Financials</h1>
                        </div>
                        <div class="col-right">
                            <p class="text-muted text-size-md">
                                We provide strategic financial planning and expertise to enhance returns and ensure the
                                enduring
                                financial vitality of your property portfolio.
                            </p>
                            <a href="{{url('services')}}" class="sliding-link text-size-1 font-weight-bold">
                                Explore Services
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="page-section">
        <div class="container">
            <h1>Join Us</h1>
            <div class="blank-1"></div>
            <div class="row row-cols-2 row-cols-lg-4">
                @foreach(get_block_items(3) as $item)
                    <div class="col card-box">
                        <div class="advantage-box border-top pt-3">
                            <h3>
                                <a href="{{url('join-us')}}">
                                    {{$item->title}}
                                </a>
                            </h3>
                            <p class="text-muted">
                                {{$item->description}}
                            </p>
                            <div class="d-flex gap-3 pb-4">
                                <a href="{{url('join-us')}}" class="sliding-link">Read More</a>
                            </div>
                        </div>
                        <div class="card-grid  border-top">
                            <div class="card-sliding">
                                <div class="card-sliding-back">
                                    <img src="{{$item->image}}" alt="">
                                    <div class="card-sliding-door">
                                        <div class="card-sliding-content">
                                            {{$item->description}}
                                        </div>
                                        <div class="card-sliding-report">
                                            <a href="{{url('join-us')}}" class="sliding-link">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection