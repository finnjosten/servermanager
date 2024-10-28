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
        <section class="vlx-header vlx-header--main">
            <div class="container">
                <div class="vlx-text vlx-text--center">
                    <h1>Server Manager</h1>
                    <small id="upate-time">Updating in </small>
                </div>
            </div>
        </section>
        <section class="vlx-block vlx-block--servers">
            <div class="container">
                <div class="inner">
                    @foreach (Nodes::all() as $node)
                        <div class="vlx-card vlx-card--server js-status" data-status="unkown" data-address="{{ $node->address }}">
                            <div class="vlx-card__body">
                                <h3>{{ $node->name }}</h3>
                                <p>User: {{ $node->ssh_user }}</p>
                                <p>Uptime: {{ $node->uptime() }}</p>
                            </div>
                            <div class="vlx-card__footer">
                                <div class="vlx-icon--wrapper">
                                    <i class="vlx-icon vlx-icon--brand-{{ $node->getOS() }} vlx-icon--x-large"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <script src="/js/servercheck.js"></script>
                </div>
            </div>
        </section>
        <section class="vlx-header vlx-header--main">
            <div class="container">
                <div class="btn-group">
                    <a href="{{ route('dashboard.node.create') }}" class="btn btn--primary btn--small">Add Server</a>
                </div>
            </div>
        </section>
    </main>

@endsection
