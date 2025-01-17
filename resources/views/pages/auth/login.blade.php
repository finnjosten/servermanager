@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Login || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    use \Illuminate\Support\Facades\Route;

    $route_home_exists = Route::has('home');
    $route_register_exists = Route::has('register');

@endphp

<main class="vlx-auth vlx-auth--login">
    <div class="vlx-block--auth">
            <a class="vlx-inner vlx-inner--btn" href="{{ $route_home_exists && route('home') }}">
                <figure class="vlx-image">
                    <img src="/images/logos/logo.svg"/>
                </figure>
            </a>
            <div class="vlx-inner vlx-inner--form">
                @if (!empty(request()->query('return')))
                    <form method="post" action="{{ route('login.post', ["return" => request()->query('return')]) }}">
                @else
                    <form method="post" action="{{ route('login.post') }}">
                @endif
                    @csrf
                    <h2>Login</h2>
                    <div class="vlx-divider">
                        <hr>
                        <p>
                            LOGIN WITH EMAIL
                        </p>
                        <hr>
                    </div>
                    <div class="vlx-input-wrapper">
                        <h4>Email</h4>
                        <input class="vlx-input" type="email" name="email" id="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="vlx-input-wrappper">
                        <h4>Password @if(env('SETTING_CAN_RESET_PASSWORD')) {{-- <a href="{{ route('forgot-password') }}">forgot password</a> --}} @endif</h4>
                        <input class="js-password" type="password" name="password" id="password" required>
                        <i class="vlx-icon vlx-icon--eye js-password-btn"></i>
                    </div>
                    <div class="vlx-input-wrapper">
                        <button class="btn btn--primary" type="submit" name="login">Login</button>
                    </div>
                    @if(env('SETTING_CAN_REGISTER') && $route_register_exists)
                        <div class="vlx-divider">
                            <hr>
                            <p>
                                <a href="{{ route('register') }}">REGISTER</a>
                            </p>
                            <hr>
                        </div>
                    @endif
                </form>

            </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInputs = document.querySelectorAll('.js-password');
        const passwordBtns = document.querySelectorAll('.js-password-btn');

        passwordBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                if (passwordInputs[index].type === 'password') {
                    passwordInputs[index].type = 'text';
                    btn.classList.remove('vlx-icon--eye');
                    btn.classList.add('vlx-icon--eye-slash');
                } else {
                    passwordInputs[index].type = 'password';
                    btn.classList.add('vlx-icon--eye');
                    btn.classList.remove('vlx-icon--eye-slash');
                }
            });
        });
    });
</script>

@endsection
