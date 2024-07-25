<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>@yield('title', settings('sitename'))-后台管理中心</title>
    <meta name="render" content="webkit">
    <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{settings('favicon')}}" rel="icon">
    <link href="{{asset('lib/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{mix_asset('dist/admin/index.css')}}" rel="stylesheet">
    <script src="{{asset('lib/echarts.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        window.siteUrl = "{{env('APP_URL')}}";
    </script>
</head>
<body>
<div id="app"></div>
<script src="{{mix_asset('dist/admin/vendors.js')}}" type="text/javascript"></script>
<script src="{{mix_asset('dist/admin/app.js')}}" type="text/javascript"></script>
</body>
</html>
