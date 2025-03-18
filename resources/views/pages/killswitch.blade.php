@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Disabled || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<main>
    <section class="block block--header block--header-home">
        <div class="container">
            <div class="text">
                <h1>{{ __('Killswitch') }}</h1>
                <h2>{{ __('This site has been disabled by a killswitch') }}</h2>
            </div>
        </div>
    </section>
</main>

@endsection
