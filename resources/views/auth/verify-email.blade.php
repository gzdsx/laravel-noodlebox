@extends('layouts.default')

@section('content')
    <section class="page-section">
        <div class="container text-center">
            <h3>Please verify your email</h3>
            <p>You're almost there! We sent an email to your email address.</p>
            <p class="mt-5">
                Just click on the link in that email to complete your signup.<br>
                If you don't see it, you may need to check your spam folder
            </p>
            <div class="mt-5">
                @if(session('message'))
                    <p class="text-success">
                        {{session('message')}}
                    </p>
                @endif
                <p>
                    Still can't find the email?
                </p>
                <div>
                    <form method="post" action="{{route('verification.send')}}">
                        @csrf
                        <button type="submit" class="btn btn-safety-orange">Resend Email</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection