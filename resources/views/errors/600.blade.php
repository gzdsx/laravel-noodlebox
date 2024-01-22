@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="error-content">
            <div class="image">
                <img src="{{asset('images/common/404.png')}}" alt="">
            </div>
            <h2>{{__($exception->getMessage() ?: 'Forbidden')}}</h2>
            <div class="links">
                <a href="{{url('/')}}">返回首页</a>
                <a href="{{url()->previous()}}">返回上一页</a>
            </div>
        </div>
    </div>
@stop
