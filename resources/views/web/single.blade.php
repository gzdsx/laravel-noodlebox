@extends('layouts.default')

@section('title', $post->title)
@section('keywords', $post->tags)
@section('description', $post->excerpt)
@section('og-image', $post->image)
@section('body-class','single')

@section('content')
    <div class="single-header bg-shake-speare">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    @foreach($post->categories as $cate)
                        <p>{{$cate->name}}</p>
                    @endforeach
                    <h1 class="text-size-4 text-break">{{$post->title}}</h1>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
        @if($post->image)
            <img src="{{$post->image}}" class="thumbnail" alt="">
        @endif
    </div>
    <div class="page-body">
        <div class="container">
            <div class="text-size-xxlg">
                {!! $post->content['content'] ?? '' !!}
            </div>
            <div class="blank-4"></div>
            <h1 class="section-heading">Related Insights</h1>
            <div class="row">
                @foreach(posts()->filter(['type'=>'post','cate'=>$post->cate_ids])->whereNotNull('image')->limit(4)->get() as $item)
                    <div class="col-12 col-md-3">
                        <div class="related-card insight-related-card">
                            <div class="card-heading">
                                <h3>
                                    <a href="{{$item->url}}">{{$item->title}}</a>
                                </h3>
                            </div>
                            <div class="card-grid">
                                <div class="card-sliding">
                                    <div class="card-sliding-back">
                                        <img src="{{$item->image}}" alt="">
                                        <div class="card-sliding-door">
                                            <div class="card-sliding-content">
                                                {!! $item->excerpt !!}
                                            </div>
                                            <div class="card-sliding-report">
                                                <a href="{{$item->url}}" class="sliding-link">See More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
