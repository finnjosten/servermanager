// so we can update the usage every 5 seconds
document.addEventListener('DOMContentLoaded', () => {
    updateUsage();

    console.log(uses_datalix);

    if (uses_datalix) {
        initWebsocket();
    }
});

function updateUsage() {
    fetch(serverApi + 'usage/', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + bearerToken,
        },
    })
        .then(response => response.json())
        .then(responseData => {
            const data = responseData.data;

            try {

                if (!uses_datalix) {
                    updateCpuUsage(data.cpu);
                    updateRamUsage(data.ram, ram_size, true);
                }

                for (let core = 0; core < cpu_cores; core++) {
                    updateCpuCoreUsage(core, data.cores[core]);
                }

                // go over all disks and find one that gives back a exsting item on the page
                let disks = data.disks;
                Object.values(disks).forEach(disk => {
                    updateDiskUsage(disk);
                });

                let network = data.network;
                document.querySelector('[data-usage="network"]').innerText = (parseFloat(network.current)).toFixed(0);
                document.querySelector('[data-usage="network_percentage"]').innerText = (parseFloat(network.current) / (max_traffic * 100) * 100).toFixed(0);
                document.querySelector('#network-bar .bar').style.width = (parseFloat(network.current) / (max_traffic * 100) * 100).toFixed(0) + "%";

            } catch (e) {
                toastError('Error updating usage. Refresh the page to start updating again.');
                console.error(e);
                return;
            }

            let countdown = 5;
            const countdownInterval = setInterval(() => {
                countdown--;
                if (countdown == 0) {
                    clearInterval(countdownInterval);
                    updateUsage();
                }
            }, 1000);
        });
};


function initWebsocket() {
    let netin = 0;
    let netout = 0;
    let netLastIn = 0;
    let netLastOut = 0;
    let netPrevIn = 0;
    let netPrevOut = 0;

    let mem = 0;
    let memmax = 0;

    let cpu = 0;

    console.log(datalix_token, datalix_id);

    try {
        webSocket = new WebSocket('wss://livedata.datalix.de');
    } catch (e) {
        console.log(e);
    }
    webSocket.onerror = function (event) {
        console.log(event);
    };
    webSocket.onopen = function (event) {
        webSocket.send(JSON.stringify({
            'token': datalix_token,
            'serviceid': datalix_id,
        }));
    };
    webSocket.onmessage = function (event) {
        if (event.data == "Error 1") {
            toastError('An error occurred while connecting to the Datalix live usage. The datalix live usage will not be updated.');
            socketNoReconnect = true;
        }
        if (event.data == "Error 2") {
            toastError('Datalix token was invalid, the datalix live usage will not be updated.');
            socketNoReconnect = true;
        }
        if (event.data == "Error 3") {
            toastError('The SM did not respond with a Pong in time. The datalix live usage will no longer be updated.');
            socketNoReconnect = true;
        }
        if (event.data == 'Ping') {
            webSocket.send('Pong');
            return;
        }
        try {
            data = JSON.parse(event.data);

            // Get net data
            if (netLastIn == 0) {
                netLastIn = data.netin;
                netLastOut = data.netout;
                netPrevIn = 0;
                netPrevOut = 0;
            }
            if (((data.netin - netLastIn) / 1000).toFixed(2) != 0) {
                netPrevIn = ((data.netin - netLastIn)).toFixed(0);
                netPrevOut = ((data.netout - netLastOut)).toFixed(0);

                netin = netPrevIn;
                netout = netPrevOut;
            } else {
                netin = netPrevIn;
                netout = netPrevOut;
            }

            netLastIn = data.netin;
            netLastOut = data.netout;

            updateNetworkUsage(netin, netout);


            mem = parseInt(data.mem / 1074000)
            memmax = parseInt(data.maxmem / 1074000)

            updateRamUsage(mem, memmax);

            cpu = parseInt(data.cpu);

            updateCpuUsage(cpu);

        } catch (error) {
            return;
        }
    }
}


function updateNetworkUsage(netin, netout) {

    // the var uplink contains the text version of the uplink we have which is "125mb/s,1000mbit/s"
    // we need to convert the uplink to bytes so we can calculate the percentage

    // split the uplink into 2 parts
    let max_uplink = uplink.split(',')[1];

    // remove the mbit/s
    max_uplink = max_uplink.replace('mbit/s', '');

    // convert the uplink to bytes
    max_uplink = max_uplink * 125000;

    document.querySelector('[data-usage="network_in"]').innerText = netin < 100000 ? `${(netin/800).toFixed(2)} KB/s` : `${(netin/800000).toFixed(2)} MB/s`;
    document.querySelector('#network-in-bar .bar').style.width = ((netin / max_uplink) * 100).toFixed(2) + "%";

    document.querySelector('[data-usage="network_out"]').innerText = netout < 100000 ? `${(netout/800).toFixed(2)} KB/s` : `${(netout/800000).toFixed(2)} MB/s`;
    document.querySelector('#network-out-bar .bar').style.width = ((netout / max_uplink) * 100).toFixed(2) + "%";

}

function updateRamUsage(mem, max, uses_gb = false) {

    nice_mem = uses_gb ? mem : (mem / 1000).toFixed(2);

    document.querySelector('[data-usage="ram"]').innerText = nice_mem;
    document.querySelector('[data-usage="ram_percentage"]').innerText = (mem / max * 100).toFixed(0);
    document.querySelector('#ram-bar .bar').style.width = (mem / max * 100).toFixed(0) + "%";
}

function updateCpuUsage(cpu) {
    document.querySelector('[data-usage="cpu_total"]').innerText = (cpu * cpu_cores).toFixed(0);
    document.querySelector('[data-usage="cpu_total_100"]').innerText = cpu;
    document.querySelector('#cpu-total-bar .bar').style.width = cpu + '%';
}

function updateCpuCoreUsage(core, usage) {
    document.querySelector(`[data-usage="cpu_core_${core}"]`).innerText = usage;
    document.querySelector(`#cpu-core-${core}-bar .bar`).style.width = usage + "%";
}

function updateDiskUsage(disk) {
    if (document.querySelector(`[data-usage="${disk.device}"]`)) {
        document.querySelector(`[data-usage="${disk.device}"]`).innerText = disk.used_gb;
        document.querySelector(`[data-usage="${disk.device}_percentage"]`).innerText = (disk.used_gb / disk.size_gb * 100).toFixed(0);
        document.querySelector(`#${disk.device}-bar .bar`).style.width = (disk.used_gb / disk.size_gb * 100).toFixed(0) + "%";
    }
}
