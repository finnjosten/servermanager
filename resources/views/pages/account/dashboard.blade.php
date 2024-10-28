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
        <section class="vlx-servers">
            <div class="container">
                <div class="inner">
                    @foreach (Nodes::all() as $node)
                        <div class="vlx-card vlx-card--server">
                            {{ $node }}
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

@endsection
