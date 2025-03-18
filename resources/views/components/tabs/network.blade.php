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
            <select type="text" id="action">
                <option value="allow" selected>ALLOW</option>
                <option value="deny">DENY</option>
            </select>
            <input type="text" id="from" placeholder="From">
            <a class="btn btn--success btn--small" id="add-port">Add</a>
        </div>

    </div>

</div>
