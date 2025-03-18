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