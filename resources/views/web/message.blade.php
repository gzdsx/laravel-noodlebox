@extends('layouts.default')

@section('title','System Message')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="message">
                <div class="message-logo">
                    <img src="{{asset('images/sterling/logo-white.png')}}" alt="">
                </div>
                <h5>{{$message ?? ''}}</h5>
                <div class="links">
                    <a href="{{url()->previous()}}">Go Back</a>
                    <a href="{{url('/')}}">Go Home</a>
                </div>
            </div>
        </div>
    </section>
@endsection