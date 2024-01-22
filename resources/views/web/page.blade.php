@extends('layouts.default')

@section('title', $page->title)

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="page-header">
                <h1 class="text-center">{{$page->title}}</h1>
            </div>
            <div class="page-content">
                {!! $page->content !!}
            </div>
        </div>
    </section>
@stop