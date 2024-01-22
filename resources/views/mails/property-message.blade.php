@extends('layouts.mail')

@section('content')
    <div class="page-section">
        <div class="container">
            <p>Name：{{$firstName ?? ''}} {{$lastName ?? ''}}</p>
            <p>Email：{{$yourMail ?? ''}}</p>
            <p>Property：{{$property->title}}</p>
            <p>{{$yourMessage ?? ''}}</p>
        </div>
    </div>
@endsection