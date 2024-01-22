<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>@yield('title', settings('sitename'))</title>
    <meta name="keywords" content="@yield('keywords', settings('keywords'))">
    <meta name="description" content="@yield('description', preg_replace('/\n|\r/','',settings('description')))">
    <meta name="render" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta property="og:locale" content="en_CA" />
    <meta property="og:type" content="property" />
    <meta property="og:title" content="@yield('title', settings('sitename'))" />
    <meta property="og:description" content="@yield('description', settings('description'))" />
    <meta property="og:url" content="{{url('')}}" />
    <meta property="og:site_name" content="{{settings('sitename')}}" />
    <meta property="og:modified_time" content="{{now()}}" />
    <meta property="og:image" content="@yield('og-image',settings('foot_logo'))" />
    <link href="https://sterlingmgmt.managebuilding.com" rel="dns-prefetch">
    <link href="{{asset('images/sterling/favicon.png')}}" rel="icon">
    <link href="{{asset('lib/bootstrap/bootstrap.min.css?v='.appversion())}}" rel="stylesheet" type="text/css">
    <link href="{{asset('lib/bootstrap-icons/bootstrap-icons.min.css?v=1.10.5')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('lib/swiper/swiper-bundle.css?v=8.4.7')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('lib/fancybox/fancybox.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dist/sterling/index.css?v='.appversion())}}" rel="stylesheet" type="text/css">
@yield('styles')
    <script src="{{asset('lib/jquery.min.js?v=1.12.4')}}" type="text/javascript"></script>
    <script src="{{asset('lib/jquery.form.min.js?v=4.3.0')}}" type="text/javascript"></script>
    <script src="{{asset('lib/bootstrap/bootstrap.bundle.min.js?v=4.6.2')}}" type="text/javascript"></script>
    <script src="{{asset('lib/swiper/swiper-bundle.min.js?v=8.4.7')}}" type="text/javascript"></script>
    <script src="{{asset('dist/custom-ui.js?v='.appversion())}}" type="text/javascript"></script>
@yield('scripts')
</head>
<body class="@yield('body-class')">
@include('web.side-nav')

<main id="main" class="main">
    <header class="header-mobile">
        <div class="header-left">
            <i class="bi bi-list" id="toggleMobileNav"></i>
        </div>
        <div class="header-center">
            <a href="{{url('/')}}">
                <img src="{{asset('images/sterling/logo-white2.png')}}" class="logo" alt="">
            </a>
        </div>
        <div class="header-right text-right">
            <a href="{{url('search')}}">
                <i class="bi bi-search"></i>
            </a>
        </div>
    </header>
    @include('web.header')
    <section>
        @yield('content')
    </section>
    @include('web.footer')
</main>

<script src="{{asset('lib/fancybox/fancybox.umd.js')}}" type="text/javascript"></script>
<script src="{{asset('dist/runtime.js?v='.appversion())}}" type="text/javascript"></script>
@yield('foot')
{!! settings('statcode') !!}
</body>
</html>
