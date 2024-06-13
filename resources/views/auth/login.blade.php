@extends('layouts.default')

@section('body-class','auth')
@section('title', trans('Login'))

@section('content')
    <section class="page-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col col-md-5">
                    <div class="btn-group btn-group-lg btn-block mb-5" id="signTabs">
                        <button type="button" class="btn btn-danger">{{__('By SMS OPT')}}</button>
                        <button type="button" class="btn btn-light">{{__('By Password')}}</button>
                    </div>
                    <div id="signBody">
                        <div class="sign-form">
                            <form method="post" class="auth-form">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <select class="form-control form-control-lg" id="signNationalCode">
                                                <option value="353">+353</option>
                                                <option value="44">+44</option>
                                                <option value="86">+86</option>
                                            </select>
                                        </div>
                                        <input type="text"
                                               name="phone"
                                               class="form-control"
                                               id="signPhone"
                                               placeholder="{{__('your phone number')}}" required="required">
                                    </div>
                                    <div class="invalid-feedback" id="errPhone" role="alert"></div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <input type="text"
                                               name="vercode"
                                               class="form-control"
                                               id="signVercode"
                                               maxlength="6"
                                               placeholder="{{__('verification code')}}" required="required">
                                        <div class="input-group-append">
                                            <button class="btn btn-light" type="button" id="btnGetCode">
                                                <span>Get code</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback" id="errVercode" role="alert"></div>
                                </div>

                                <div class="form-group">
                                    <button type="button"
                                            class="btn btn-danger btn-lg btn-block"
                                            id="btnSignWithSms">{{__('Sign in')}}</button>
                                </div>
                                <div class="auth-form-links">
                                    <a href="{{route('password.request')}}">{{__('Forget password')}}?</a>
                                    <span>or</span>
                                    <a href="{{route('register')}}">{{__('Registration')}}</a>
                                </div>
                            </form>
                        </div>

                        <div class="sign-form">
                            <form method="post" class="auth-form">
                                @csrf
                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <i class="input-group-text bi bi-envelope"></i>
                                        </div>
                                        <input type="email"
                                               name="email"
                                               id="signEmail"
                                               class="form-control"
                                               placeholder="{{__('your email address')}}" required="required">
                                    </div>
                                    <div class="invalid-feedback" role="alert" id="errEmail"></div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <i class="input-group-text bi bi-lock"></i>
                                        </div>
                                        <input type="password"
                                               name="password"
                                               id="signPassword"
                                               class="form-control"
                                               placeholder="{{__('your password')}}" required="required">
                                    </div>
                                    <div class="invalid-feedback" role="alert" id="errPassword"></div>
                                </div>

                                <div class="form-group">
                                    <button type="button"
                                            class="btn btn-danger btn-lg btn-block"
                                            id="btnLoginWithPwd">{{__('Sign in')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="blank-1"></div>
                    <div class="auth-or">
                        <span>OR</span>
                    </div>
                    <div class="form-group">
                        <a href="{{url('auth/google')}}" class="btn btn-light btn-block btn-lg">
                            <i class="bi bi-google"></i>
                            <span>{{__('Login with Google')}}</span>
                        </a>
                    </div>
                    <p class="text-bull-cyan">
                        <small>
                            By creating an account or signing in, I agree to the <a href="{{url('terms')}}"
                                                                                    target="_blank"
                                                                                    class="text-safety-orange">Terms</a>
                            of Use and have read our
                            <a href="{{url('privacy')}}" target="_blank" class="text-safety-orange">Privacy</a> Policy.
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <script>
        (function ($) {
            $(function () {
                $("#signTabs .btn").on('click', function () {
                    $(this).addClass('btn-danger')
                        .removeClass('btn-light')
                        .siblings()
                        .addClass('btn-light')
                        .removeClass('btn-danger');
                    $("#signBody .sign-form").eq($(this).index()).show().siblings().hide();
                });

                $("#btnGetCode").on('click', function () {
                    var phone_number = $.trim($("#signPhone").val());
                    var national_number = $.trim($("#signNationalCode").val());
                    if (phone_number === '') {
                        $("#errPhone").show().text("{{__('validation.custom.mobile.required')}}");
                        return false;
                    } else {
                        if (!/\d/.test(phone_number)) {
                            $("#errPhone").show().text("{{__('validation.custom.mobile.digits')}}");
                            return false;
                        }
                    }

                    $.ajax({
                        url: "{{url('/api/v1/captcha/sms')}}",
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            phone_number: phone_number,
                            national_number: national_number
                        },
                        success: function (data) {
                            $("#btnGetCode").addClass('disabled').text("{{__('Sending')}}");
                            var count = 60;
                            var timer = setInterval(function () {
                                count--;
                                if (count > 0) {
                                    $("#btnGetCode").text("Retrieve in " + count + "s");
                                } else {
                                    $("#btnGetCode").removeClass('disabled').text("{{__('Retrieve')}}");
                                    clearInterval(timer);
                                }
                            }, 1000);
                        },
                        error: function (xhr) {
                            //console.log(xhr);
                            $("errPhone").show().text(xhr.responseJSON.message);
                        }
                    });
                });

                $("#btnSignWithSms").on('click', function () {
                    $(".invalid-feedback").hide();
                    var check = true;
                    var phone = $.trim($("#signPhone").val());
                    if (phone === '') {
                        $("#errPhone").show().text("{{__('validation.custom.mobile.required')}}");
                        check = false;
                    } else {
                        if (!/\d/.test(phone)) {
                            $("#errPhone").show().text("{{__('validation.custom.mobile.digits')}}");
                            check = false;
                        }
                    }

                    var signVercode = $.trim($("#signVercode").val());
                    if (signVercode.length !== 6) {
                        $("#errVercode").show().text("{{__('validation.custom.vercode.required')}}");
                        check = false;
                    }

                    var national_number = $.trim($("#signNationalCode").val());
                    if (check) {
                        $.ajax({
                            url: "{{route('login.sms')}}",
                            type: "POST",
                            data: {
                                _token: "{{csrf_token()}}",
                                phone_number: phone,
                                national_number: national_number,
                                vercode: signVercode
                            },
                            beforeSend: function () {
                                $("#btnSignWithSms").addClass('disabled').text("{{__('Logining...')}}");
                            },
                            success: function (data) {
                                window.location.assign('{{request('redirect','/')}}')
                            },
                            error: function (xhr) {
                                //console.log(xhr);
                                $("#errVercode").show().text(xhr.responseJSON.message);
                            },
                            complete: function () {
                                $("#btnSignWithSms").removeClass('disabled').text("{{__('Login in')}}");
                            }
                        });
                    }
                });

                $("#btnLoginWithPwd").on('click', function () {
                    var email = $.trim($("#signEmail").val());
                    if (email === '') {
                        $("#errEmail").text("{{__('validation.custom.email.required')}}");
                        return false;
                    } else {
                        if (!/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/.test(email)) {
                            $("#errEmail").text("{{__('validation.custom.email.email')}}");
                            return false;
                        }
                    }
                    var password = $.trim($("#signPassword").val());
                    if (password === '') {
                        $("#errPassword").text("{{__('validation.custom.password.required')}}");
                        return false;
                    }

                    $.ajax({
                        url: "{{route('login')}}",
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            account: email,
                            password: password
                        },
                        success: function (data) {
                            window.location.assign('{{request('redirect','/')}}');
                        },
                        error: function (xhr) {
                            //console.log(xhr);
                            $("#errPassword").text(xhr.responseJSON.message).show();
                        }
                    });
                });
            })
        })(jQuery)
    </script>
@stop