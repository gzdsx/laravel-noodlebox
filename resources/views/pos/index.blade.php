<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>@yield('title', 'Pos')</title>
    <meta name="keywords" content="@yield('keywords', settings('keywords'))">
    <meta name="description" content="@yield('description', settings('description'))">
    <meta name="render" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link href="{{asset('images/common/favicon.png')}}" rel="icon">
    <link href="{{asset('images/pos/yith-pos-icon/yith-pos-icon.css')}}" rel="stylesheet">
    <link href="{{asset('dist/pos/index.css?v='.appversion())}}" rel="stylesheet">
</head>
<body>
<div id="app">@yield('content')</div>
@yield('foot')
<script src="{{asset('dist/pos/index.js?v='.appversion())}}" type="text/javascript"></script>
</body>
</html>
