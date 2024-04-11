@extends('layouts.default')

@section('title', __('Registration'))
@section('body-class','auth')

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col col-md-4">
                    <h1 class="text-center auth-form-header">{{__('Create your account')}}</h1>
                    <form method="post" class="auth-form">
                        @csrf
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <input type="text" name="nickname" value="{{old('nickname')}}"
                                       class="form-control {{$errors->has('nickname') ? ' is-invalid' : ''}}"
                                       placeholder="Nickname" required="required">
                                @if ($errors->has('nickname'))
                                    <div class="invalid-feedback show"
                                         role="alert">{{$errors->first('nickname')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                </div>
                                <input type="text" name="email" value="{{old('email')}}"
                                       class="form-control {{$errors->has('email') ? ' is-invalid' : ''}}"
                                       placeholder="Email" required="required">
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback show"
                                         role="alert">{{$errors->first('email')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="bi bi-key"></i>
                                    </div>
                                </div>
                                <input type="password" name="password" value="{{old('password')}}"
                                       class="form-control {{$errors->has('password') ? ' is-invalid' : ''}}"
                                       placeholder="Password" required="required">
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback show"
                                         role="alert">{{$errors->first('password')}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="mb-md-2">
                            <button type="submit" class="btn btn-danger btn-lg btn-block">{{__('Continue')}}</button>
                        </div>
                        <div class="auth-form-links">
                            <span>Already have an account?</span>
                            <a href="{{route('login')}}">Sign in</a>
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
@endsection
