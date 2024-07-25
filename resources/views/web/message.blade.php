@extends('layouts.default')

@section('title','System Message')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="message text-center" style="padding-top: 5rem;">
                        <h3 class="text-safety-orange">{{$title ?? ''}}</h3>
                        <p class="text-safety-orange">{{$message ?? ''}}</p>
                        <div class="links">
                            <a href="{{url()->previous()}}">Go Back</a>
                            <a href="{{url('/')}}">Go Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection