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
            min-height: 800px;
        }

        .text-center{
            text-align: center;
        }

        .form-group{
            margin-bottom: 1rem;
        }

        .mail-header {
            display: flex;
            margin-bottom: 2rem;
            justify-content: right;
            text-align: right;
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
<div class="mail-header">
    <div class="text-right text-muted">
        <div>Strata, Residential & Commercial Property Management</div>
        <div>admin@sterlingmgmt.ca | sterlingrealtygroup.com</div>
    </div>
</div>

<main class="main">
    @yield('content')
</main>

<div class="mail-footer">
    <div>PROPERTY MANAGEMENT</div>
    <div>RESIDENTIAL ● COMMERCIAL ● STRATA</div>
</div>
</body>
</html>