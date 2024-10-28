@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Dashboard || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

    @php
        use \App\Models\Node as Nodes;
    @endphp

    <main class="page page--account dashboard">
        <section class="vlx-block vlx-block--servers">
            <div class="container">
                <div class="inner">
                    @foreach (Nodes::all() as $node)
                        @php
                            $node->status = $node->status();
                        @endphp
                        <div class="vlx-card vlx-card--server">
                            <div class="vlx-card__body">
                                <h3>{{ $node->name }}</h3>
                                <p>User: {{ $node->ssh_user }}</p>
                                <p>Key: {{ $node->ssh_key }}</p>
                            </div>
                            <div class="vlx-card__footer">
                                <div class="vlx-icon--wrapper">
                                    <i class="vlx-icon vlx-icon--brand-ubuntu vlx-icon--x-large"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

@endsection
