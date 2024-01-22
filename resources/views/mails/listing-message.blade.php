@extends('layouts.mail')

@section('content')
    <div class="page-section">
        <div class="container">
            <h3><a href="{{$listing->url}}" target="_blank">Leasing Lead：{{$listing->formatted_address}}</a></h3>
            <p>Name：{{$messages['firstName'] ?? ''}} {{$messages['lastName'] ?? ''}}</p>
            <p>Email：{{$messages['yourEmail'] ?? ''}}</p>
            <p>Phone Number：{{$messages['yourPhone'] ?? ''}}</p>
            <p>Monthly Income：${{$messages['Income'] ?? ''}}</p>
            <p>Pets：{{$messages['Pets'] ?? ''}}</p>
            <p>Lease Plan：{{$messages['LeasePlan'] ?? ''}}</p>
            <p>{{$messages['yourMessage'] ?? ''}}</p>
        </div>
    </div>
@endsection