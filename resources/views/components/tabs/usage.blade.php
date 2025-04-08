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

        @php
            $node_uplink = $node_data->hardware->network->uplink ?? "unkown";
            if ($node_uplink != "unkown") {
                $node_uplink = explode(',', $node_uplink)[1];
            }
        @endphp

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

        <div class="block__usage block__usage--icon">
            <div class="vlx-text">
                <h2>Network in</h2>
                <p>
                    <span data-usage="network_in">0 Kbit/s</span>
                    <small>({{ $node_uplink }})</small>
                </p>
            </div>
            <div id="network-in-bar" class="progress-bar">
                <div class="bar" style="width: 0%;"></div>
            </div>
        </div>

        <div class="block__usage block__usage--icon">
            <div class="vlx-text">
                <h2>Network out</h2>
                <p>
                    <span data-usage="network_out">0 Kbit/s</span>
                    <small>({{ $node_uplink }})</small>
                </p>
            </div>
            <div id="network-out-bar" class="progress-bar">
                <div class="bar" style="width: 0%;"></div>
            </div>
        </div>

    </div>

    <div class="block span--4">
        @if ($node->user_id == auth()->id())
            @if ($node->datalix_id)
                <p>Datalix ID is present and the SM will try to use the Datalix Websocket for usage.</p>
                <p>Using datalix usage means the CPU, RAM and Net updates are faster.<br>But the SM will use the node api for CPU Cores, Disk and Net Total usage but dont update as fast.</p>
            @else
                <p>Datalix ID is <i>not</i> present. The SM will use the nodes api to retrieve usage.</p>
                <p>CPU, Ram and Net usage will not be as fast. Net in and Net out usage will not work!</p>
            @endif
        @else
            <p>Since you are not the owner the server will default to the API usage endpoint.</p>
        @endif
    </div>

</div>
