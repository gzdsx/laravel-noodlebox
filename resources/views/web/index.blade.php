@extends('layouts.default')

@section('body-class','home')

@section('content')
    <section class="home-video-bg">
        <video src="{{asset('images/video-bg.mp4')}}" autoplay muted loop></video>
        <div class="home-video-content">
            <div class="container">
                <img src="{{asset('images/noodlebox/logo-large.png')}}" class="logo-large" alt=""/>
                <h3 class="font-weight-bold text-center text-white">
                    Order Online !
                </h3>
                <h3 class="font-weight-bold text-center text-safety-orange">
                    Choose The Shop Closest To You
                </h3>
                <div class="col col-md-6">
                    <a href="{{url('shop')}}" class="home-btn">
                        <i class="bi bi-basket"></i>
                        <span>DROGHEDA SHOP</span>
                    </a>
                    <a href="{{url('points-mall')}}" class="home-btn btn-points-mall">
                        <i class="bi bi-gift"></i>
                        <span>POINTS MALL</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="home-map">
        <div class="container map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2361.1678905288245!2d-6.357203784027461!3d53.71527145471395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4867398a1da33dd7%3A0xf99a601514c74d7e!2sDao%20Noodle%20Box!5e0!3m2!1szh-CN!2sie!4v1590345310109!5m2!1szh-CN!2sie"
                    class="absolute-fill" frameborder="0" style="border: 0; pointer-events: none;" allowfullscreen=""
                    aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="col col-md-6">
            <div class="action-buttons">
                <a href="{{url('/')}}" class="home-btn">
                    <i class="bi bi-hand-index"></i>
                    <span> Order From DROGHEDA SHOP</span>
                </a>
            </div>
        </div>
    </section>
@endsection