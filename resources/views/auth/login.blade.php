@extends('layouts.default')

@section('body-class','auth')
@section('title', trans('Login'))

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col col-md-5">
                    <div id="loginApp"></div>
                </div>
            </div>
        </div>
    </section>
    <script>var redirectUrl = "{{ request('redirect') }}";</script>
@stop