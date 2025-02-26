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

    fetch(`/api/nodes/${node_id}/network/${port}/add?action=${action}&from=${from}`)
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
    fetch(`/api/nodes/${node_id}/network/${port}/delete`)
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
