@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Edit nodes || {{ env('APP_NAME') }}</title>

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
                        @if($mode != "create")
                            <a class="btn btn--primary btn--small" href="{{ route('dashboard.node', $node->id) }}"><i class="vlx-icon vlx-icon--arrow-left vlx-icon--small"></i>Go back</a>
                        @else
                            <a class="btn btn--primary btn--small" href="{{ route('dashboard.main') }}"><i class="vlx-icon vlx-icon--arrow-left vlx-icon--small"></i>Go back</a>
                        @endif
                        @if($mode == "edit")
                            <a class="btn btn--danger btn--small" href="{{ route('dashboard.node.trash', $node->id) }}"><i class="vlx-icon vlx-icon--trash vlx-icon--small"></i>Delete</a>
                        @elseif($mode == "delete")
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
