@extends('layouts.default')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h3>{{ __('Verify Your Email Address') }}</h3>
                    <div>
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    <div class="mt-4">{{ __('If you did not receive the email') }},</div>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit"
                                class="btn btn-link text-safety-orange p-0 m-0 align-baseline">{{ __('click here to request another') }}.</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
