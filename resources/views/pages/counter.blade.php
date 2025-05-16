@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Counter || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

<section class="counter">
    @livewire(Counter::class)
</section>

@endsection
