
document.addEventListener("DOMContentLoaded", function () {
    const servers = document.querySelectorAll(".js-status");
    const updateText = document.querySelector("#upate-time");

    servers.forEach(server => {
        const serverUrl = server.getAttribute("data-address");
        checkServerStatus(server, serverUrl);
    });

    function recheckStatus() {
        updateText.textContent = "Updating now";
        servers.forEach(server => {
            const serverUrl = server.getAttribute("data-address");
            server.setAttribute("data-status", "unkown");
            checkServerStatus(server, serverUrl);
        });
        setTimeout(null, 500)
        let countdown = 10;
        const countdownInterval = setInterval(() => {
            updateText.textContent = `Updating in ${countdown}s`;
            countdown--;
            if (countdown < 0) {
            clearInterval(countdownInterval);
            recheckStatus();
            }
        }, 1000);
    }

    recheckStatus();

    function checkServerStatus(card, url) {
        const proxyUrl = '/api/nodes/status/' + encodeURIComponent(url);
        const xhr = new XMLHttpRequest();
        xhr.open("GET", proxyUrl, true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                card.setAttribute("data-status", "online");
            } else if (xhr.status >= 400 && xhr.status < 500) {
                card.setAttribute("data-status", "unkown");
            } else {
                card.setAttribute("data-status", "offline");
            }
        };

        xhr.onerror = function () {
            console.error("Error making request to", url);
            card.classList.remove("unkown");
            card.classList.add("unkown");
            text.textContent = "Status: unkown";
        };

        xhr.send();
    }
});
