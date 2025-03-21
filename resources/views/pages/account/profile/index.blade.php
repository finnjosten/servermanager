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

    @php
        $user = Auth::user();
    @endphp

    <main class="page page--account view view--menu">
        <section class="vlx-block vlx-block--form">
            <div class="container container--x-small">

                <div class="vlx-block__header">
                    <div class="btn-group btn-group--left">
                        <a class="btn btn--warning btn--small" href="{{ route('dashboard.main') }}"><i class="vlx-icon vlx-icon--arrow-left vlx-icon--small"></i>Go back</a>
                        <a class="btn btn--warning btn--small" href="{{ route('profile.edit') }}"><i class="vlx-icon vlx-icon--pencil vlx-icon--small"></i>Edit</a>
                    </div>
                </div>

                <div class="inner">
                    <form method="POST" class="vlx-form" action="{{ route('logout') }}">
                        @csrf

                        <div class="vlx-form__box">
                            <div class="vlx-input-box">
                                <label class="h4">UUID</label>
                                <input readonly required name="uuid" value="{{ $user->uuid }}">
                            </div>
                        </div>

                        <div class="vlx-form__box vlx-form__box--hor">
                            <div class="vlx-input-box">
                                <label class="h4">Name</label>
                                <input readonly required name="name" value="{{ $user->name }}">
                            </div>
                            <div class="vlx-input-box">
                                <label class="h4">Email</label>
                                <input readonly required name="email" value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="vlx-form__box">
                            <div class="vlx-input-box">
                                <label class="h4">Datalix Token</label>
                                <input readonly required name="datalix_token" value="{{ vlxIsEncrypted($user->datalix_token) ? Crypt::decrypt($user->datalix_token) : $user->datalix_token }}">
                            </div>
                        </div>

                        <div class="vlx-form__box">
                            <button type="submit" name="logout" class="btn btn--danger btn--small">
                                <i class="vlx-icon vlx-icon--arrow-left-from-line vlx-icon--small"></i>
                                Logout
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </section>
    </main>

@endsection
