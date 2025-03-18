@extends('layouts.app')

@section('show-nav', 'false')

<!-- Page head -->
@section('head')

<title>Node || {{ env('APP_NAME') }}</title>

@endsection

<!-- Page content -->
@section('content')

    @php

        $node_data = $node->get_all();

    @endphp

    <main class="node-overview">
        <section class="vlx-header vlx-header--server">
            <div class="container">
                <div class="inner">

                    <div class="vlx-top-bar">
                        <div class="vlx-breadcrumbs">
                            <a href="{{ route('dashboard.main') }}"><i class="vlx-icon vlx-icon--arrow-left"></i></a>
                            <a href="{{ route('dashboard.main') }}">Servers</a>
                            <span>/</span>
                            <a class="active">{{ $node->fqdn }}</a>
                        </div>
                        <a href="{{ route('dashboard.node.edit', $node->id) }}">
                            <i class="vlx-icon vlx-icon--gear"></i>
                        </a>
                    </div>

                    <div class="vlx-info-center">
                        <div class="vlx-icon--wrapper">
                            <i class="vlx-icon vlx-icon--server vlx-icon--xx-large"></i>
                        </div>
                        <div class="vlx-text">
                            <h1 class="js-status" data-status="unkown" data-address="{{ $node->fqdn ?? $node->ipv4 }}">{{ $node->fqdn ?? $node->name }}</h1>
                            <div class="vlx-subtext">
                                <p>
                                    <i class="vlx-icon vlx-icon--ethernet"></i>
                                    {{ $node_data->hardware->network->ipv4 ?? "unkown" }}
                                </p>

                                <i class="vlx-icon vlx-icon--dot"></i>
                                <p>
                                    <i class="vlx-icon vlx-icon--hard-drive"></i>
                                    {{ $node_data->hardware->cpu->cpu_cores ?? "unkown" }} vCPU / {{ $node_data->hardware->memory->size ?? "unkown" }} Memory / {{ $node_data->hardware->disk->size ?? "unkown" }} Disk
                                </p>

                                <i class="vlx-icon vlx-icon--dot"></i>
                                <p>
                                    <i class="vlx-icon vlx-icon--compact-disc"></i>
                                    {{ $node_data->os ?? "unkown" }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="vlx-tabs">
                        <a data-tab-target="overview" class="active"><i class="vlx-icon vlx-icon--browser"></i>Overview</a>
                        <a data-tab-target="usage" class=""><i class="vlx-icon vlx-icon--square-poll-vertical"></i>Usage</a>
                        <a data-tab-target="network" class=""><i class="vlx-icon vlx-icon--ethernet"></i>Network</a>
                        <a data-tab-target="users" class=""><i class="vlx-icon vlx-icon--user"></i>Users</a>
                        <a data-tab-target="webserver" class=""><i class="vlx-icon vlx-icon--hard-drive"></i>Webserver</a>
                        <a data-tab-target="webapps" class=""><i class="vlx-icon vlx-icon--globe"></i>Webapps</a>
                    </div>

                </div>
            </div>
        </section>

        <section class="vlx-block vlx-block--node">
            <div class="container">

                @include('components.tabs.overview')
                @include('components.tabs.usage')
                @include('components.tabs.network')
                @include('components.tabs.users')
                @include('components.tabs.webserver')
                @include('components.tabs.webapps')

            </div>
        </section>

        <div class="vlx-outer-modal js-modal--webapp" id="vlx-webapp-modal">
            <div class="vlx-modal vlx-modal--webapp">
                <a class="vlx-close-btn js-close-modal">
                    <div class="vlx-icon--wrapper">
                        <i class="vlx-icon vlx-icon--xmark"></i>
                    </div>
                </a>
                <form class="vlx-form">
                    @csrf

                    <div class="vlx-form__box vlx-form__box--hor">
                        <div class="vlx-input-box">
                            <label class="h4">Project name</label>
                            <div class="vlx-input">
                                <input type="text" data-key="project_name" placeholder="Cool project">
                            </div>
                        </div>
                        <div class="vlx-input-box">
                            <label class="h4">Public address</label>
                            <div class="vlx-input">
                                <input type="text" data-key="public_address" placeholder="https://project.test/">
                            </div>
                        </div>
                    </div>
                    <div class="vlx-form__box">
                        <div class="vlx-input-box">
                            <label class="h4">Folder name</label>
                            <div class="vlx-input">
                                <input type="text" data-key="name" placeholder="Webapp Name" readonly>
                            </div>
                        </div>
                        <div class="vlx-input-box">
                            <label class="h4">Folder location</label>
                            <div class="vlx-input">
                                <input type="text" data-key="location" placeholder="/var/www/vhost/project.test" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="vlx-form__box vlx-form__box--hor">
                        <div class="vlx-input-box">
                            <label class="h4">Project Type</label>
                            <div class="vlx-input">
                                <input type="text" data-key="type" placeholder="Laravel" readonly>
                            </div>
                        </div>
                        <div class="vlx-input-box">
                            <label class="h4">Creation date</label>
                            <div class="vlx-input">
                                <input type="date" data-key="created_at" placeholder="2000-01-01">
                            </div>
                        </div>
                    </div>
                    <div class="vlx-form__box">
                        <div class="vlx-input-box">
                            <label class="h4">Description</label>
                            <div class="vlx-input">
                                <textarea data-key="description"></textarea>
                            </div>
                        </div>
                        <div class="vlx-input-box">
                            <label class="h4">Notes</label>
                            <div class="vlx-input">
                                <textarea data-key="notes"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="vlx-form__box vlx-form__box--hor">
                        <div class="vlx-input-box">
                            <label class="h4">Github</label>
                            <div class="vlx-input">
                                <input type="text" data-key="repository_url" placeholder="https://github.com/user/project">
                            </div>
                        </div>
                        <div class="vlx-input-box">
                            <label class="h4">Environment</label>
                            <div class="vlx-input">
                                <input type="text" data-key="environment" placeholder="production">
                            </div>
                        </div>
                    </div>

                    <div class="btn-group btn-group--left">
                        <a class="btn btn--success btn--small js-save-webapp">Save</a>
                        <a class="btn btn--danger btn--small js-delete-webapp">Delete</a>
                    </div>

                        {{--
                            "name": "servermanager.vacso.cloud",
                            "type": "laravel",
                            "meta": {
                                "project_name": "Server Manager",
                                "public_address": "https://servermanager.vacso.cloud",
                                "description": "Server Manager is a web application that allows you to manage your servers and services in a simple and easy way.",
                                "created_at": "2024-09-28",
                                "repository_url": "https://github.com/finnjosten/servermanager",
                                "environment": "development",
                                "notes": "This is a development version of the application. It is not recommended for production use."
                            },
                            "id": 0,
                            "location": "/var/www/vhost/servermanager.vacso.cloud"
                        --}}
                </form>
            </div>
        </div>

        <div class="vlx-outer-modal" id="vlx-webapp-modal-add">
            <div class="vlx-modal vlx-modal--webapp">
                <a class="vlx-close-btn js-close-modal">
                    <div class="vlx-icon--wrapper">
                        <i class="vlx-icon vlx-icon--xmark"></i>
                    </div>
                </a>
                <form class="vlx-form" action="{{ route('api.node.webapp.add', $node->id) }}" method="POST">
                    @csrf

                    {{-- Domain --}}
                    <div class="vlx-form__box vlx-form__box--hor">
                        <div class="vlx-input-box">
                            <label class="h4">Subdomain</label>
                            <div class="vlx-input">
                                <input type="text" name="subdomain" placeholder="project">
                            </div>
                        </div>
                        <div class="vlx-input-box">
                            <label class="h4">domain</label>
                            <div class="vlx-input">
                                <select name="domain">
                                    <option>vacso.cloud</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Github --}}
                    <div class="vlx-form__box vlx-form__box--hor">
                        <div class="vlx-input-box">
                            <div class="vlx-input-box">
                                <label class="h4">Github Link</label>
                                <div class="vlx-input">
                                    <input type="text" name="github_link" placeholder="https://github.com/user/project">
                                </div>
                            </div>
                        </div>
                        <div class="vlx-input-box">
                            <label class="h4">Git type</label>
                            <div class="vlx-input">
                                <select name="github_type">
                                    <option value="clone">Clone</option>
                                    <option value="template">Template</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Project Name --}}
                    <div class="vlx-form__box vlx-form__box--hor">
                        <div class="vlx-input-box">
                            <label class="h4">Project name</label>
                            <div class="vlx-input">
                                <input type="text" name="project_name" id="project_name" placeholder="Webapp Name">
                            </div>
                        </div>
                        <div class="vlx-input-box">
                            <label class="h4">Folder location</label>
                            <div class="vlx-input">
                                <input class="js-auto-update" type="text" name="location" data-auto-update="project_name" data-auto-update-prefix="/var/www/vhost/" placeholder="/var/www/vhost/project.test" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Project Type --}}
                    <div class="vlx-form__box vlx-form__box--hor">
                        <div class="vlx-input-box">
                            <label class="h4">Project Type</label>
                            <div class="vlx-input">
                                <select name="type">
                                    <option>Laravel</option>
                                    <option>Wordpress</option>
                                    <option>React</option>
                                    <option>HTML</option>
                                    <option>Docker</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="vlx-form__box">
                        <div class="vlx-input-box">
                            <label class="h4">ENV File</label>
                            <div class="vlx-input">
                                <textarea data-key="env_file"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group btn-group--left">
                        <a class="btn btn--success btn--small js-save-webapp">Save</a>
                        <a class="btn btn--danger btn--small js-delete-webapp">Delete</a>
                    </div>

                        {{--
                            "name": "servermanager.vacso.cloud",
                            "type": "laravel",
                            "meta": {
                                "project_name": "Server Manager",
                                "public_address": "https://servermanager.vacso.cloud",
                                "description": "Server Manager is a web application that allows you to manage your servers and services in a simple and easy way.",
                                "created_at": "2024-09-28",
                                "repository_url": "https://github.com/finnjosten/servermanager",
                                "environment": "development",
                                "notes": "This is a development version of the application. It is not recommended for production use."
                            },
                            "id": 0,
                            "location": "/var/www/vhost/servermanager.vacso.cloud"
                        --}}
                </form>
            </div>
        </div>

        <script>
            const node_id = {{ $node->id }};
            const cpu_cores = {{ $node_data->hardware->cpu->cpu_cores ?? 0 }};
            const ram_size = {{ str_replace(" GB", "", ($node_data->hardware->memory->size ?? "0 GB")) }};
            const max_traffic = {{ trim(str_replace(["GB","TB"], "", ($node_data->hardware->network->traffic ?? "0 GB"))) }};
            // This is your node endpoint and bearer token, this is used to request data from your nodes api.
            const serverApi = "{{ $node->endpoint }}";
            const bearerToken = "{{ decrypt($node->key) }}";
        </script>

        <script src="/js/nodeusage.js"></script>
        <script src="/js/tabcontroller.js"></script>
        <script src="/js/servercheck.js"></script>
        <script src="/js/portmanager.js"></script>
        <script src="/js/modal.js"></script>
    </main>

@endsection
