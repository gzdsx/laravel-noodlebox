@extends('layouts.default')

@section('title', $page->title)
@section('keywords', $page->keywords)
@section('description', $page->description)
@section('body-class', 'page page-'.$page->id)
@section('og-type','page')

@section('content')
    <div class="page-banner">
        <img src="{{asset('storage/image/2024/03/rmixvP3ywRWRlvWHPOGVNyilUlCtOoM6l8CGwvJ9.jpg')}}" alt="">
    </div>
    <div class="page-section">
        <div class="container">
            <div class="page-content">{!! $page->content !!}</div>
        </div>
    </div>
@endsection