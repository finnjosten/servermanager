@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Edit categories || {{ env('APP_NAME') }}</title>

<link rel="stylesheet" href="/css/datatables.css?v=1.13.7" />
<script src="/js/datatables.js?v=1.13.7"></script>

@endsection

<!-- Page content -->
@section('content')

    <main class="page page--account view view--menu">
        <section class="vlx-for">
            <div class="container">
                <div class="content">
                    <div class="btn-group btn-group--left">
                        <a class="btn btn--primary btn--small" href="{{ route('dashboard.main') }}">Go back<i class="vlx-icon vlx-icon--rotate-left vlx-icon--small"></i></a>
                        @if($mode == "edit")
                            <a class="btn btn--primary btn--small btn--danger" href="{{ route('dashboard.node.trash', $node->id) }}"><i class="vlx-icon vlx-icon--trash vlx-icon--small"></i>Delete</a>
                        @endif
                    </div>

                    @if($mode == 'delete')
                        @include('components.forms.node.trash', ['node' => $node] )
                    @elseif($mode == 'edit')
                        @include('components.forms.node.edit', ['node' => $node] )
                    @elseif($mode == 'create')
                        @include('components.forms.node.create')
                    @endif

                </div>

            </div>
        </section>
    </main>

@endsection
