<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>@yield('title','Home')-{{settings('sitename')}}</title>
    <meta name="keywords" content="@yield('keywords', settings('keywords'))">
    <meta name="description" content="@yield('description', preg_replace('/\n|\r/','',settings('description')))">
    <meta name="render" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta property="og:locale" content="en_UK" />
    <meta property="og:type" content="@yield('og-type', 'website')" />
    <meta property="og:title" content="@yield('title', settings('sitename'))" />
    <meta property="og:description" content="@yield('description', settings('description'))" />
    <meta property="og:url" content="{{url('')}}" />
    <meta property="og:site_name" content="{{settings('sitename')}}" />
    <meta property="og:modified_time" content="{{now()}}" />
    <meta property="og:image" content="@yield('og-image',settings('logo'))" />
    <link href="https://noodlebox.ie" rel="dns-prefetch">
    <link href="{{settings('favicon')}}" rel="icon">
    <link href="{{asset('lib/bootstrap/bootstrap.min.css?v='.appversion())}}" rel="stylesheet" type="text/css">
    <link href="{{asset('lib/bootstrap-icons/bootstrap-icons.min.css?v=1.10.5')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('lib/swiper/swiper-bundle.css?v=8.4.7')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('lib/fancybox/fancybox.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dist/web/index.css?v='.appversion())}}" rel="stylesheet" type="text/css">
@yield('styles')
    <script src="{{asset('lib/jquery.min.js?v=3.4.0')}}" type="text/javascript"></script>
    <script src="{{asset('lib/fancybox/fancybox.umd.js')}}" type="text/javascript"></script>
    <script src="{{asset('lib/bootstrap/bootstrap.bundle.min.js?v=4.6.2')}}" type="text/javascript"></script>
    <script src="{{asset('lib/swiper/swiper-bundle.min.js?v=8.4.7')}}" type="text/javascript"></script>
    <script src="{{asset('dist/web/vendor.js?v='.appversion())}}" type="text/javascript"></script>
@yield('scripts')
</head>
<body class="@yield('body-class','body') mobile-body">
@yield('header-before')
@yield('header', view('web.header'))
@yield('header-mobile', view('web.header-mobile'))
@yield('header-after')
<main id="main" class="main">
    @yield('content')
</main>
@yield('footer-before')
@yield('footer', view('web.footer'))
@yield('footer-after')
<div id="noodlebox"></div>
{!! settings('statcode') !!}
<script src="{{asset('dist/web/runtime.js?v='.appversion())}}" type="text/javascript"></script>
@yield('footer-scripts')
</body>
</html>
