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
