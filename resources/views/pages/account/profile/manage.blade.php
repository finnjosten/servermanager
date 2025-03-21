@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Edit profile || {{ env('APP_NAME') }}</title>

<link rel="stylesheet" href="/css/datatables.css?v=1.13.7" />
<script src="/js/datatables.js?v=1.13.7"></script>

@endsection

<!-- Page content -->
@section('content')

    <main class="page page--account view view--menu">
        <section class="vlx-block vlx-block--form">
            <div class="container container--x-small">

                <div class="vlx-block__header">
                    <div class="btn-group btn-group--left">
                        <a class="btn btn--warning btn--small" href="{{ route('profile') }}"><i class="vlx-icon vlx-icon--arrow-left vlx-icon--small"></i>Go back</a>
                        @if($mode == "edit")
                            <a class="btn btn--danger btn--small" href="{{ route('profile.trash') }}"><i class="vlx-icon vlx-icon--trash vlx-icon--small"></i>Delete</a>
                        @endif
                    </div>
                </div>

                <div class="inner">
                    @if($mode == 'edit')
                        @include('components.forms.user.edit', ['user' => $user])
                    @elseif($mode == 'delete')
                        @include('components.forms.user.trash')
                    @endif
                </div>

            </div>
        </section>
    </main>

@endsection
