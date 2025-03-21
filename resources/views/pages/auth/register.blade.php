@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Register || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

@php
    use \Illuminate\Support\Facades\Route;

    $route_home_exists = Route::has('home');

@endphp

<main class="auth register">
    <section class="vlx-block vlx-block--auth">
        <div class="vlx-container d-flex">

            <form
                method="post"
                class="vlx-card vlx-card--auth vlx-card--register"

                @if (!empty(request()->query('return')))
                    action="{{ route('register.post', ["return" => request()->query('return')]) }}"
                @else
                    action="{{ route('register.post') }}"
                @endif
            >
                <div class="vlx-card__header">
                    <img src="{{ env('APP_LOGO') }}" alt="{{ env('APP_NAME') }}" class="logo">
                </div>

                <div class="vlx-card__body">
                    @csrf

                    <div class="input-wrapper input-wrapper--email">
                        <label for="email">Email Address</label>
                        <div class="input">
                            <i class="vlx-icon vlx-icon--envelope"></i>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="input-wrapper input-wrapper--email">
                        <label for="name">Name</label>
                        <div class="input">
                            <i class="vlx-icon vlx-icon--user"></i>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="input-wrapper input-wrapper--password">
                        <label for="password">Password</label>
                        <div class="input">
                            <i class="vlx-icon vlx-icon--lock"></i>
                            <input class="js-password" type="password" name="password" id="password" required>
                            <i class="vlx-icon vlx-icon--eye js-password-btn"></i>
                        </div>
                    </div>
                </div>

                <div class="vlx-card__footer">
                    <button class="btn">Register</button>
                    <div class="vlx-btn-bar">
                        <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </form>

        </div>
    </section>

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
