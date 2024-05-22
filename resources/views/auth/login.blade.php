@extends('layouts.default')

@section('body-class','auth')
@section('title', trans('Login'))

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col col-md-4">
                    <h1 class="text-center auth-form-header">{{__('Welcome back')}}</h1>
                    <form method="post" class="auth-form">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="account"
                                   class="form-control form-control-lg{{$errors->has('account') ? ' is-invalid' : ''}}"
                                   placeholder="{{__('Phone/Email')}}" required="required">
                            @if ($errors->has('account'))
                                <div class="invalid-feedback show"
                                     role="alert">{{$errors->first('account')}}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" name="password"
                                   class="form-control form-control-lg{{$errors->has('password') ? ' is-invalid' : ''}}"
                                   placeholder="{{__('Password')}}" required="required">
                            @if ($errors->has('password'))
                                <div class="invalid-feedback show"
                                     role="alert">{{$errors->first('password')}}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger btn-lg btn-block">{{__('Login')}}</button>
                        </div>
                        <div class="auth-form-links">
                            <a href="{{route('password.request')}}">{{__('Forget password')}}?</a>
                            <span>or</span>
                            <a href="{{route('register')}}">{{__('Registration')}}</a>
                        </div>
                    </form>

                    <div class="blank-1"></div>
                    <div class="auth-or">
                        <span>OR</span>
                    </div>

                    <div class="auth-socials">
                        <a href="{{url('auth/google')}}">
                            <i class="bi bi-google"></i>
                        </a>
                        <a href="{{url('auth/facebook')}}">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="{{url('auth/github')}}">
                            <i class="bi bi-github"></i>
                        </a>
                        <a href="{{url('auth/twitter')}}">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop