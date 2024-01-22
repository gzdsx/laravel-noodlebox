@extends('layouts.mail')

@section('content')
    <div class="page-section">
        <div class="container">
            @foreach($messages as $k=>$v)
                <div class="form-group" style="margin-bottom: 10px;">
                    <strong>{{$k}}:</strong>
                    <span>{{$v}}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection