<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', env('APP_NAME'))</title>
    <meta name="keywords" content="@yield('keywords', settings('keywords'))">
    <meta name="description" content="@yield('description', settings('description'))">
    <meta name="render" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="{{asset('images/common/favicon.png')}}" rel="icon">
    <link href="{{asset('lib/vant/vant.min.css?v=2.0')}}" rel="stylesheet">
    <link href="{{asset('dist/h5/index.css?v='.appversion())}}" rel="stylesheet">
@yield('styles')
    <script src="{{asset('lib/vue/vue-chunk.js?v='.appversion())}}" type="text/javascript"></script>
    <script src="{{asset('lib/vue/vue-router.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('lib/vant/vant.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        window.isSignined = '{{auth()->check() ? '1' : '0'}}';
        window.ua = navigator.userAgent.toLowerCase();
        window.baseUrl = '{{url('/')}}';
    </script>
@yield('scripts')
</head>
<body>
<div id="app">@yield('content')</div>
@yield('foot')
<script src="{{asset('dist/h5/index.js?v='.appversion())}}" type="text/javascript"></script>
</body>
</html>
