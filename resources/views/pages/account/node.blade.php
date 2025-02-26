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
                        <a data-tab-target="web" class=""><i class="vlx-icon vlx-icon--globe"></i>Webapps</a>
                    </div>

                </div>
            </div>
        </section>

        <section class="vlx-block vlx-block--node">
            <div class="container">

                <div class="inner inner--overview active" data-tab-id="overview">
                    <div class="block cpu">
                        <div class="heading">
                            <div class="vlx-icon--wrapper">
                                <i class="vlx-icon vlx-icon--xx-large vlx-icon--microchip"></i>
                            </div>
                            <h2>CPU</h2>
                        </div>
                        <h3>Model</h3>
                        <p>{{ $node_data->hardware->cpu->model ?? "unkown" }}</p>
                        <h3>Speed</h3>
                        <p>{{ $node_data->hardware->cpu->cpu_mhz ?? "unkown" }}</p>
                        <h3>Cores</h3>
                        <p>{{ $node_data->hardware->cpu->cpu_cores ?? "unkown" }}</p>
                        <h3>Cache</h3>
                        <p>{{ $node_data->hardware->cpu->cache_size ?? "unkown" }}</p>
                    </div>
                    <div class="block memory">
                        <div class="heading">
                            <div class="vlx-icon--wrapper">
                                <i class="vlx-icon vlx-icon--xx-large vlx-icon--memory"></i>
                            </div>
                            <h2>Memory</h2>
                        </div>
                        <h3>Size</h3>
                        <p>{{ $node_data->hardware->memory->size ?? "unkown" }}</p>
                        <h3>Speed</h3>
                        <p>{{ $node_data->hardware->memory->speed ?? "unkown" }}</p>
                        <h3>Type</h3>
                        <p>{{ $node_data->hardware->memory->type ?? "unkown" }}</p>
                        <h3>Form Factor</h3>
                        <p>{{ $node_data->hardware->memory->form_factor ?? "unkown" }}</p>
                        <h3>Eror Correction</h3>
                        <p>{{ $node_data->hardware->memory->error_correction_type ?? "unkown" }}</p>
                    </div>
                    <div class="block disk">
                        <div class="heading">
                            <div class="vlx-icon--wrapper">
                                <i class="vlx-icon vlx-icon--xx-large vlx-icon--hard-drive"></i>
                            </div>
                            <h2>Disk</h2>
                        </div>
                        <h3>Size</h3>
                        <p>{{ $node_data->hardware->disk->size ?? "unkown" }}</p>
                        <h3>Buffer Size</h3>
                        <p>{{ $node_data->hardware->disk->buffer_size ?? "unkown" }}</p>
                        <h3>Type</h3>
                        <p>{{ $node_data->hardware->disk->type ?? "unkown" }}</p>
                        <h3>Disk name</h3>
                        <p>{{ $node_data->hardware->disk->disk_name ?? "unkown" }}</p>
                        <h3>Mount Point</h3>
                        <p>{{ $node_data->hardware->disk->mount_point ?? "unkown" }}</p>
                    </div>
                    <div class="block network">
                        <div class="heading">
                            <div class="vlx-icon--wrapper">
                                <i class="vlx-icon vlx-icon--xx-large vlx-icon--ethernet"></i>
                            </div>
                            <h2>Network</h2>
                        </div>
                        <h3>IPv4</h3>
                        <p>{{ $node_data->hardware->network->ipv4 ?? "unkown" }}</p>
                        <h3>IPv6</h3>
                        <p>{{ $node_data->hardware->network->ipv6 ?? "unkown" }}</p>
                        <h3>FQDN</h3>
                        <p>{{ $node_data->hardware->network->fqdn ?? "unkown" }}</p>
                        <h3>Traffic</h3>
                        <p>{{ $node_data->hardware->network->traffic ?? "unkown" }}</p>
                        <h3>Uplink</h3>
                        <p>{{ explode(",", ($node_data->hardware->network->uplink ?? ","))[0] ?? "Unkown" }} <small>({{ explode(",", ($node_data->hardware->network->uplink ?? ","))[1] ?? "Unkown" }})</small></p>
                    </div>
                </div>

                <div class="inner inner--usage" data-tab-id="usage">
                    <div class="block cpu">


                        <div class="block__usage block__usage--icon">
                            <div class="heading">
                                <div class="vlx-icon--wrapper">
                                    <i class="vlx-icon vlx-icon--xx-large vlx-icon--microchip"></i>
                                </div>
                                <div class="vlx-text">
                                    <h2>CPU Total</h2>
                                    <p>
                                        <span data-usage="cpu_total">0</span>%
                                        / {{ 100 * ($node_data->hardware->cpu->cpu_cores ?? 1) }}%
                                        <small>(<span data-usage="cpu_total_100">0</span>% / 100%)</small>
                                    </p>
                                </div>
                            </div>
                            <div id="cpu-total-bar" class="progress-bar">
                                <div class="bar" style="width: 0%;"></div>
                            </div>
                        </div>

                        @for ($core = 0; $core < ($node_data->hardware->cpu->cpu_cores ?? 0); $core++)
                            <div class="block__usage block__usage--icon">
                                <div class="vlx-text">
                                    <h2>Core {{ $core }}</h2>
                                    <p>
                                        <span data-usage="cpu_core_{{ $core }}">0</span>%
                                        / 100%
                                    </p>
                                </div>
                                <div id="cpu-core-{{ $core }}-bar" class="progress-bar">
                                    <div class="bar" style="width: 0%;"></div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="block ram">
                        <div class="block__usage block__usage--icon">
                            <div class="heading">
                                <div class="vlx-icon--wrapper">
                                    <i class="vlx-icon vlx-icon--xx-large vlx-icon--memory"></i>
                                </div>
                                <div class="vlx-text">
                                    <h2>Memory</h2>
                                    <p>
                                        <span data-usage="ram">0</span> GB
                                        / {{$node_data->hardware->memory->size ?? "Unkown" }}
                                        <small>(<span data-usage="ram_percentage">0</span>% / 100%)</small>
                                    </p>
                                </div>
                            </div>
                            <div id="ram-bar" class="progress-bar">
                                <div class="bar" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="block disk">
                        <div class="block__usage block__usage--icon">
                            <div class="heading">
                                <div class="vlx-icon--wrapper">
                                    <i class="vlx-icon vlx-icon--xx-large vlx-icon--hard-drive"></i>
                                </div>
                                <div class="vlx-text">
                                    <h2>Disk</h2>
                                    <p>
                                        <span data-usage="{{ $node_data->hardware->disk->disk_name ?? null }}">0</span> GB
                                        / {{ $node_data->hardware->disk->size ?? "Unkown" }}
                                        <small>(<span data-usage="{{ $node_data->hardware->disk->disk_name ?? null }}_percentage">0</span>% / 100%)</small>
                                    </p>
                                </div>
                            </div>
                            <div id="{{$node_data->hardware->disk->disk_name ?? null }}-bar" class="progress-bar">
                                <div class="bar" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="block network">
                        <div class="block__usage block__usage--icon">
                            <div class="heading">
                                <div class="vlx-icon--wrapper">
                                    <i class="vlx-icon vlx-icon--xx-large vlx-icon--ethernet"></i>
                                </div>
                                <div class="vlx-text">
                                    <h2>Network</h2>
                                    <p>
                                        <span data-usage="network">0</span> GB
                                        / {{$node_data->hardware->network->traffic ?? "Unkown" }}
                                        <small>(<span data-usage="network_percentage">0</span>% / 100%)</small>
                                    </p>
                                </div>
                            </div>
                            <div id="network-bar" class="progress-bar">
                                <div class="bar" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="inner inner--network" data-tab-id="network">
                    @php
                        $ports = $node->get_ports();
                        $locked_ports = $node->get_locked_ports();
                    @endphp

                    <div class="vlx-block vlx-block--table js-ports-table">
                        <div class="vlx-row vlx-row--header">
                            <h4>Port</h4>
                            <h4>Action</h4>
                            <h4>From</h4>
                            <h4>Remove</h4>
                        </div>

                        @foreach ($ports as $port)
                            <div class="vlx-row vlx-row--port">
                                <input value="{{ $port->port }}" disabled>
                                <input value="{{ $port->action }}" disabled>
                                <input value="{{ $port->from }}" disabled>
                                <!-- on click do js call to remove port "/api/nodes/network/{node:id}/ports/{port}/delete" -->
                                @if (in_array($port->port, $locked_ports))
                                    <a class="btn btn--danger btn--small btn--disabled">Remove</a>
                                @else
                                    <a class="btn btn--danger btn--small js-remove-port" data-port="{{ $port->port }}">Remove</a>
                                @endif
                            </div>
                        @endforeach

                        <div class="vlx-row vlx-row--footer">
                            <input required type="text" id="port" placeholder="Port">
                            <input type="text" id="action" placeholder="Action">
                            <input type="text" id="from" placeholder="From">
                            <a class="btn btn--success btn--small" id="add-port">Add</a>
                        </div>

                    </div>

                </div>

                <div class="inner inner--users" data-tab-id="users">

                </div>

                <div class="inner inner--web" data-tab-id="web">
                    <div class="vlx-block vlx-block--webapps">
                        @if (isset($node_data->webapps))
                            @foreach ($node_data->webapps as $webapp)
                                <div class="vlx-card vlx-card--webapp js-toggle-modal" data-target-modal="webapp-modal" data-api-target="{{ $webapp->name }}">
                                    <div class="vlx-icon--wrapper">
                                        <i class="vlx-icon vlx-icon--xx-large
                                            @if ($webapp->type == "laravel")
                                                vlx-icon--brand-laravel
                                            @elseif ($webapp->type == "wordpress")
                                                vlx-icon--brand-wordpress
                                            @elseif ($webapp->type == "react")
                                                vlx-icon--brand-react
                                            @elseif ($webapp->type == "html")
                                                vlx-icon--brand-html5
                                            @else
                                                vlx-icon--globe
                                            @endif
                                        "></i>
                                    </div>
                                    <h3 class="vlx-card__title">{{ $webapp->meta->project_name ?? $webapp->name }}</h3>

                                    @if (!empty($webapp->meta->public_address))
                                        <div class="vlx-meta vlx-meta--public-address">
                                            <i class="vlx-icon vlx-icon--link"></i>
                                            <small>{{ $webapp->meta->public_address }}</small>
                                        </div>
                                    @endif
                                    @if (!empty($webapp->location))
                                        <div class="vlx-meta vlx-meta--location">
                                            <i class="vlx-icon vlx-icon--folder"></i>
                                            <small>{{ $webapp->location ?? null }}</small>
                                        </div>
                                    @endif

                                    @if (!empty($webapp->meta->public_address))
                                        <a class="vlx-floating-btn" href="{{ $webapp->meta->public_address }}" target="_blank">
                                            <i class="vlx-icon vlx-icon--arrow-up-right-from-square vlx-icon--medium"></i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                            <div class="vlx-card vlx-card--webapp-new js-toggle-modal" data-target-modal="webapp-modal-add">
                                <div class="vlx-icon--wrapper">
                                    <i class="vlx-icon vlx-icon--plus"></i>
                                </div>
                                <h3 class="vlx-card__title">New webapp</h3>
                            </div>
                        @endif
                    </div>
                </div>

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
