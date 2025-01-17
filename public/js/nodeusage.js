// so we can update the usage every 5 seconds
document.addEventListener('DOMContentLoaded', () => {
    updateUsage();
});

function updateUsage() {
    fetch(serverApi + 'usage', {
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

                document.querySelector('[data-usage="cpu_total"]').innerText = (data.cpu * cpu_cores).toFixed(0);
                document.querySelector('[data-usage="cpu_total_100"]').innerText = (data.cpu).toFixed(0);
                document.querySelector('#cpu-total-bar .bar').style.width = data.cpu + "%";

                for (let core = 0; core < cpu_cores; core++) {
                    document.querySelector(`[data-usage="cpu_core_${core}"]`).innerText = data.cores[core];
                    document.querySelector(`#cpu-core-${core}-bar .bar`).style.width = data.cores[core] + "%";
                }

                document.querySelector('[data-usage="ram"]').innerText = data.ram;
                document.querySelector('[data-usage="ram_percentage"]').innerText = (data.ram / ram_size * 100).toFixed(0);
                document.querySelector('#ram-bar .bar').style.width = (data.ram / ram_size * 100).toFixed(0) + "%";

                // go over all disks and find one that gives back a exsting item on the page
                let disks = data.disks;
                Object.values(disks).forEach(disk => {
                    if (document.querySelector(`[data-usage="${disk.device}"]`)) {
                        document.querySelector(`[data-usage="${disk.device}"]`).innerText = disk.used_gb;
                        document.querySelector(`[data-usage="${disk.device}_percentage"]`).innerText = (disk.used_gb / disk.size_gb * 100).toFixed(0);
                        document.querySelector(`#${disk.device}-bar .bar`).style.width = (disk.used_gb / disk.size_gb * 100).toFixed(0) + "%";
                    }
                });

                let network = data.network;
                document.querySelector('[data-usage="network"]').innerText = (parseFloat(network.current)).toFixed(0);
                document.querySelector('[data-usage="network_percentage"]').innerText = (parseFloat(network.current) / (max_traffic * 100) * 100).toFixed(0);
                document.querySelector('#network-bar .bar').style.width = (parseFloat(network.current) / (max_traffic * 100) * 100).toFixed(0) + "%";

            } catch (e) {
                toastr.error('Error updating usage. Refresh the page to start updating again.');
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
