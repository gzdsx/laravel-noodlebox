<!DOCTYPE html>
<html lang="zh">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>@yield('title', settings('sitename'))</title>
    <meta name="keywords" content="@yield('keywords', settings('keywords'))">
    <meta name="description" content="@yield('description', settings('description'))">
    <meta name="render" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="{{asset('images/sterling/favicon.png')}}" rel="icon">
    <style type="text/css">
        .container {
            max-width: 1140px;
            margin: 0 auto;
        }

        .mail-header {
            display: flex;
            margin-bottom: 2rem;
        }
        .mail-title {
            display: block;
            text-align: center;
        }
        .mail-text-underline {
            text-decoration: underline;
        }
        .mail-row {
            display: flex;
            display: -webkit-box;
            -moz-column-gap: 10px;
            column-gap: 10px;
        }
        .mail-col {
            -webkit-flex: 1;
            -webkit-box-flex: 1;
        }
        .mail-group {
            display: -webkit-box;
            -moz-column-gap: 3px;
            column-gap: 3px;
        }
        .mail-group__label {
            display: block;
            margin-right: 3px;
            white-space: nowrap;
        }
        .mail-group__value {
            -webkit-flex: 1;
            -webkit-box-flex: 1;
            border-bottom: 1px solid #333;
            padding-left: 5px;
            padding-right: 5px;
        }
        .mail-footer {
            margin-top: 4rem;
            padding-bottom: 2rem;
            text-align: center;
            font-weight: 500;
        }
    </style>
</head>
<body class="@yield('body-class')">

<main class="main">
    @yield('content')
</main>

</body>
</html>