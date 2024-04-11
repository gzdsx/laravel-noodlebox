@extends('layouts.default')

@section('title', $page->title)
@section('keywords', $page->keywords)
@section('description', $page->description)
@section('body-class', 'page page-'.$page->id)
@section('og-type','page')

@section('content')
    @php
        $photos = \App\Models\PhotoWall::get();
    @endphp
    <div class="page-section">
        <div class="container">
            <div class="photo-walls">
                @foreach($photos as $photo)
                    <div class="photo-item" data-fancybox="gallery" src="{{$photo->image}}">
                        <img src="{{asset('images/noodlebox/placeholder.png')}}" data-src="{{$photo->thumb}}" alt="{{$photo->title}}" class="img-fluid">
                    </div>
                @endforeach
            </div>
        </div>
        <script>
            (function () {
                Fancybox.bind("[data-fancybox=gallery]", {
                    // Your custom options
                });
            })()
        </script>
    </div>
@endsection