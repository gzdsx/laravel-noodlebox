@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="error-content">
            <div class="image">
                <img src="{{asset('images/common/404.png')}}" alt="">
            </div>
            <h2>{{$exception->getMessage() ?: 'The requested URL was not found on this server.'}}</h2>
            <div class="links">
                <a href="{{url('/')}}">Go Home</a>
                <a href="{{back()->getTargetUrl()}}">Go Back</a>
            </div>
        </div>
    </div>
@stop
