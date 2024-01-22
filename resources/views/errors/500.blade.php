@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="error-content">
            <div class="image">
                <img src="{{asset('images/sterling/link_fail.png')}}">
            </div>
            <h2>{{__($exception->getMessage() ?: 'Forbidden')}}</h2>
            <div class="links">
                <a href="{{url()->previous()}}">Go Back</a>
                <a href="{{url('/')}}">Go Home</a>
            </div>
        </div>
    </div>
@stop
