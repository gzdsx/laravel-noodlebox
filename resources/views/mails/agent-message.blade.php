@extends('layouts.mail')

@section('content')
    <div class="container">
        <p>Hello {{$agent->name}},</p>
        <p></p>
        <p>
            My Name is {{$userMessages['firstName'] ?? ''}} {{$userMessages['lastName'] ?? ''}},
            Email:{{$userMessages['yourEmail'] ?? ''}},
            Phone Number:{{$userMessages['yourPhone'] ?? ''}}
        </p>
        <p>I am {{$userMessages['iAm'] ?? ''}}</p>
        <p>{{$userMessages['yourMessage'] ?? ''}}</p>
        <p></p>
        <p>{{now()->format('Y-m-d H:i:s')}}</p>
    </div>
@endsection