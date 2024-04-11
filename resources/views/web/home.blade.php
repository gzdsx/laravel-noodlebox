<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>@yield('title', '用户中心')</title>
    <meta name="keywords" content="@yield('keywords', settings('keywords'))">
    <meta name="description" content="@yield('description', settings('description'))">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="{{asset('images/common/favicon.png')}}" rel="icon">
    <link href="{{asset('lib/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('lib/element/element-ui.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dist/home/index.css?v='.appversion())}}" rel="stylesheet" type="text/css">
</head>
<body class="user-home">
<div class="user-top">
    <div class="logo">
        <a href="{{url('/')}}">
            <img src="{{settings('logo')}}" alt="">
        </a>
    </div>
    <div class="flex-grow-1"></div>
    <div class="top-right">
        <a href="{{url('shop')}}">Our Shop</a>
        <a href="{{url('home')}}" class="account">
            <img src="{{auth()->user()->avatar}}" class="avatar" alt="">
            <span>{{auth()->user()->nickname}}</span>
        </a>
        <a href="{{route('logout')}}">{{trans('logout')}}</a>
    </div>
</div>
<div id="app"></div>
<script src="{{asset('lib/vue/vue-chunk.js?v='.appversion())}}" type="text/javascript"></script>
<script src="{{asset('lib/vue/vue-router.min.js')}}" type="text/javascript"></script>
<script src="{{asset('lib/element/element-ui.js')}}" type="text/javascript"></script>
<script src="{{asset('dist/home/app.js?v='.appversion())}}" type="text/javascript"></script>
</body>
</html>