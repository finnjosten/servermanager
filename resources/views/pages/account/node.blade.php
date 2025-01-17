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
                        <a data-tab-target="web" class=""><i class="vlx-icon vlx-icon--globe"></i>Web</a>
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
                        <p>{{ explode(",", ($node_data->hardware->network->uplink ?? ","))[0] ?? "Unkown" }}<small>({{ explode(",", ($node_data->hardware->network->uplink ?? ","))[1] ?? "Unkown" }})</small></p>
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
                                    <h2>RAM</h2>
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
                                    <a class="btn btn--primary btn--small btn--disabled">Remove</a>
                                @else
                                    <a class="btn btn--primary btn--small js-remove-port" data-port="{{ $port->port }}">Remove</a>
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
                        @foreach ($node_data->webapps as $webapp)
                            <div class="vlx-card vlx-card--webapp">
                                <div class="vlx-icon--wrapper">
                                    @if ($webapp->type == "laravel")
                                        <i class="vlx-icon vlx-icon--brand-laravel"></i>
                                    @elseif ($webapp->type == "wordpress")
                                        <i class="vlx-icon vlx-icon--brand-wordpress"></i>
                                    @elseif ($webapp->type == "react")
                                        <i class="vlx-icon vlx-icon--brand-react"></i>
                                    @elseif ($webapp->type == "html")
                                        <i class="vlx-icon vlx-icon--brand-html5"></i>
                                    @else
                                        <i class="vlx-icon vlx-icon--globe"></i>
                                    @endif
                                </div>
                                <h3>{{ $webapp->name }}</h3>
                                <p>{{ $webapp->type }}</p>
                            </div>
                    @endforeach
                </div>

            </div>
        </section>

        <script>
            const cpu_cores = {{ $node_data-> hardware -> cpu -> cpu_cores ?? 0 }};
            const ram_size = {{ str_replace(" GB", "", ($node_data -> hardware -> memory -> size ?? "0 GB")) }};
            const max_traffic = {{ trim(str_replace(["GB","TB"], "", ($node_data -> hardware -> network -> traffic ?? "0 GB"))) }};
            // This is your node endpoint and bearer token, this is used to request data from your nodes api.
            const serverApi = "{{ $node->endpoint }}";
            const bearerToken = "{{ decrypt($node->key) }}";
        </script>

        <script src="/js/nodeusage.js"></script>
        <script src="/js/tabcontroller.js"></script>
        <script src="/js/servercheck.js"></script>
        <script>

            const addPortButton = document.getElementById('add-port');
            const portsTable = document.querySelector('.js-ports-table');

            addPortButton.addEventListener('click', () => {
                const port = document.getElementById('port').value;
                let action = document.getElementById('action').value.toUpperCase();
                console.log(action);

                if (!action) {
                    action = 'ALLOW';
                }
                let from = document.getElementById('from').value;
                if (!from) {
                    from = 'Anywhere';
                }

                if (!port) {
                    toastr.error('Port is required');
                    return;
                }

                fetch(`/api/nodes/{{ $node->id }}/network/${port}/add?action=${action}&from=${from}`)
                .then(response => {
                    if (response.ok) {
                        // Show success toast
                        toastr.success(`Port ${port} added`);

                        // Insert new row
                        createRowElement(port, action, from);

                        // Clear the inputs
                        document.getElementById('port').value = '';
                        document.getElementById('action').value = '';
                        document.getElementById('from').value = '';

                        return response.json();
                    } else {
                        toastr.error(`Failed to add port ${port}`);
                    }
                });
            });

            function createRowElement(port, action, from) {
                // Get the vlx-row--footer element and add a row above it
                let newRow = document.createElement('div');
                newRow.classList.add('vlx-row', 'vlx-row--port');
                newRow.innerHTML = `<input value="${port}" disabled><input value="${action}" disabled><input value="${from}" disabled><a class="btn btn--primary btn--small js-remove-port" data-port="${port}">Remove</a>`;
                portsTable.insertBefore(newRow, portsTable.querySelector('.vlx-row--footer'));

                initRemovePortButtons();
            }


            // function to reindex and redo the event listeners

            initRemovePortButtons();

            function initRemovePortButtons() {
                let removePortButtons = document.querySelectorAll('.js-remove-port');

                removePortButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        let port = event.target.getAttribute('data-port');
                        port = port.replace('/udp', '').replace('/tcp', '');
                        removePort(button, port);
                    });
                });
            }

            function removePort(button, port) {
                button.parentElement.classList.add("--loading");
                fetch(`/api/nodes/{{ $node->id }}/network/${port}/delete`)
                .then(response => {
                    if (response.ok) {
                        button.parentElement.remove();
                        toastr.success(`Port ${port} removed`);
                        return response.json();
                    } else {
                        button.parentElement.classList.remove('--loading');
                        toastr.error(`Failed to remove port ${port}`);
                    }
                });
            }
        </script>
    </main>

@endsection
