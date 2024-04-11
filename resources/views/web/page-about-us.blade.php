@extends('layouts.default')

@section('title', $page->title)
@section('keywords', $page->keywords)
@section('description', $page->description)
@section('body-class','about')
@section('og-type','page')

@section('content')
    <div class="about-banner">
        <img src="{{asset('images/noodlebox/guo4.jpg')}}" alt="">
        <h1>WE BELIEVE IN THE POWER OF THE WOK</h1>
    </div>
    <div class="page-section bg-bull-cyan">
        <div class="container text-white h4">
            To turn a humble kitchen into a fiery theatre. And transform the simplest of ingredients into a feast that’s
            out of this world. Inspired by the hawker food markets of Asia and armed with the mighty wok in all its
            sizzling hot and smoky glory, our wok chefs take market fresh ingredients and fire them up for that amazing
            wok-charred flavour, right before your eyes. It’s the taste of Asia in a box, ready when you are.
            Noodle Box. Wok inspired, market fresh.
        </div>
    </div>
    <div class="about-banner">
        <img src="{{asset('images/noodlebox/banner-e1602186784250.jpg')}}" alt="">
        <h1>A FIERY START</h1>
    </div>
    <div class="page-section bg-bull-cyan">
        <div class="container text-white h4">
            In 2010, a young couple from China took their taste buds Come to Drogheda.and the wok-fired flavours of the
            East Asian food have inspired them ever since. Today, Noodle Box is a neighborhood classic. And you can find
            us serving up an ever-evolving menu of wok inspired, market fresh creations to hundreds of hungry Noodle
            Boxers every day.
        </div>
    </div>
    <div class="page-section">
        <div class="container">
            <div class="our-teams">
                <div class="our-team">
                    <img src="{{asset('images/noodlebox/benson.png')}}" alt="" class="our-team__image">
                    <h5>Benson Zhu<br>DIRECT</h5>
                    <div class="text-safety-orange">
                        Our flame-taming wok chefs work their fiery magic in every Noodle Box kitchen, giving every dish
                        its unforgettable wok-charred flavour.
                    </div>
                </div>
                <div class="our-team">
                    <img src="{{asset('images/noodlebox/Selina.png')}}" alt="" class="our-team__image">
                    <h5>Selina Wang<br>DIRECT</h5>
                    <div class="text-safety-orange">
                        Freshness means flavour, so we use the freshest local market produce we can find to ensure you
                        get maximum crispiness, crunchiness and tastiness in every bit.
                    </div>
                </div>
                <div class="our-team">
                    <img src="{{asset('images/noodlebox/gui.png')}}" alt="" class="our-team__image">
                    <h5>Zengui Wang<br>HEAD CHEF</h5>
                    <div class="text-safety-orange">
                        Crafted from traditional Asian recipes and mastered for modern tastes, our secret sauces add
                        sizzle and scorch to every Noodle Box dish.
                    </div>
                </div>
                <div class="our-team">
                    <img src="{{asset('images/noodlebox/roisin.png')}}" alt="" class="our-team__image">
                    <h5>Roisin Warnett<br>MANAGER</h5>
                    <div class="text-safety-orange">
                        Our not-so-secret secret weapon, the wok is the key to the distinctively Asian flavours that
                        keep you coming back for more.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection