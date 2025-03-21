@extends('layouts.app')

@section('show-nav', 'false')

@section('head')

<title>{{ $code }} || {{ env('APP_NAME') }}</title>

@endsection

@section('content')

@php
    use \Illuminate\Support\Facades\Route;
    $route_home_exists = Route::has('home');
    $route_dashboard_exists = Route::has('dashboard.main');
@endphp

<main>
    <section class="vlx-block vlx-block--error">
        <div class="container">
            <div class="inner d-flex--center">
                <div class="text">
                    <h1>{{ $code }}</h1>
                    <p class="h2">{{ $message }}</p>
                    <div class="btn-group">
                        @auth
                            @if ($route_home_exists)
                                <a href="{{ route('home') }}" class="btn btn--primary btn--small">Go home!</a>
                            @endif
                            @if ($route_dashboard_exists)
                                <a href="{{ route('dashboard.main') }}" class="btn btn--primary btn--small">Go to your dashboard!</a>
                            @endif
                        @endauth
                        @guest
                            @if ($route_home_exists)
                                <a href="{{ route('home') }}" class="btn btn--primary btn--small">Go home!</a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
