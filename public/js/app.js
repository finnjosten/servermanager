function vlx_get_cookie(cookie_name) {
    return document.cookie.split(';').find(cookie => cookie.includes(cookie_name));
}

function vlx_get_cookie_val(cookie_name) {
    let cookie_val = document.cookie.split(';').find(cookie => cookie.includes(cookie_name));
    if (cookie_val) {
        return cookie_val.split('=')[1];
    }
    return '';
}

function vlx_set_cookie(cookie_name, data, time) {
    data = JSON.stringify(data);
    document.cookie = `${cookie_name}=${data}; expires=${time}; path=/`;
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


function reloadcss() {
    document.querySelectorAll("link[rel=stylesheet]").forEach(link => link.href = link.href.replace(/\?.*|$/, "?" + Date.now()))
    return "CSS Reloading...";
}



document.addEventListener('DOMContentLoaded', () => {
    initAutoUpdater();

    document.addEventListener('livewire:init', () => {
        initVlxLivewire();
    });
});


function initVlxLivewire() {
    let click_btns = document.querySelectorAll('.lw-click');
    click_btns.forEach(btn => {
        btn.addEventListener('click', () => {
            let event = btn.dataset.lwEvent;
            let params = JSON.parse(btn.dataset.lwParams ?? '{}');

            if (event) {
                Livewire.dispatch(event, params);
            }
        });
    });

    let outside_click_btns = document.querySelectorAll('.lw-outside-click');
    outside_click_btns.forEach(btn => {
        document.addEventListener('click', (event) => {
            if (!btn.contains(event.target)) {
                let event = btn.dataset.lwEvent;
                let params = JSON.parse(btn.dataset.lwParams ?? '{}');

                if (event) {
                    Livewire.dispatch(event, params);
                }
            }
        });
    });

    let hover_btns = document.querySelectorAll('.lw-hover');
    hover_btns.forEach(btn => {
        btn.addEventListener('mouseover', () => {
            let event = btn.dataset.lwEvent;
            let params = JSON.parse(btn.dataset.lwParams ?? '{}');

            if (event) {
                Livewire.dispatch(event, params);
            }
        });
    });


    Livewire.on('vlx-toast', (data) => {
        if (data.type === 'success') {
            toastSuccess(data.message, data.second_message);
        } else if (data.type === 'info') {
            toastInfo(data.message, data.second_message);
        } else if (data.type === 'warning') {
            toastWarning(data.message, data.second_message);
        } else if (data.type === 'error') {
            toastError(data.message, data.second_message);
        } else {
            console.log(data);
        }
    });
}


initAutoUpdater = () => {
    let updating_inputs = document.querySelectorAll('.js-auto-update');

    updating_inputs.forEach(input => {
        let updating_input_from = document.getElementById(input.getAttribute('data-auto-update'));
        let prefix = input.getAttribute('data-auto-update-prefix') ?? "";
        let suffix = input.getAttribute('data-auto-update-suffix') ?? "";

        if (updating_input_from) {
            updating_input_from.addEventListener('input', () => {
                input.value = prefix + updating_input_from.value + suffix;
            });
        } else {
            // Get the nearest parent form and in that form find the input with the name
            let form = input.closest('form');
            let input_name = input.getAttribute('name');
            let updating_input_from = form.querySelector(`input[name="${input_name}"]`);

            if (updating_input_from) {
                updating_input_from.addEventListener('input', () => {
                    input.value = prefix + updating_input_from.value + suffix;
                });
            }
        }
    });

}



function toastSuccess(message, second_message) {
    if (isToastrAvailable()) {
        toastr.success(message);

        if (second_message) {
            toastr.success(second_message);
        }
    }

    if (isNotyfAvailable()) {
        notyf.open({type: 'success', message: message});

        if (second_message) {
            notyf.open({type: 'success', message: second_message});
        }
    }

    console.log(message, second_message);
}


function toastInfo(message, second_message) {
    if (isToastrAvailable()) {
        toastr.info(message);

        if (second_message) {
            toastr.info(second_message);
        }
    }

    if (isNotyfAvailable()) {
        notyf.open({type: 'info', message: message});

        if (second_message) {
            notyf.open({type: 'info', message: second_message});
        }
    }

    console.log(message, second_message);
}


function toastWarning(message, second_message) {
    if (isToastrAvailable()) {
        toastr.warning(message);

        if (second_message) {
            toastr.warning(second_message);
        }
    }

    if (isNotyfAvailable()) {
        notyf.open({type: 'warning', message: message});

        if (second_message) {
            notyf.open({type: 'warning', message: second_message});
        }
    }

    console.warn(message, second_message);
}


function toastError(message, second_message) {
    if (isToastrAvailable()) {
        toastr.error(message);

        if (second_message) {
            toastr.error(second_message);
        }
    }

    if (isNotyfAvailable()) {
        notyf.open({type: 'error', message: message});

        if (second_message) {
            notyf.open({type: 'error', message: second_message});
        }
    }

    console.error(message, second_message);
}


// Check if toastr or notyf are defined and available before using them
function isToastrAvailable() {
    return typeof toastr !== 'undefined' && toastr !== null;
}

function isNotyfAvailable() {
    return typeof notyf !== 'undefined' && notyf !== null;
}
