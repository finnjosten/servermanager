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
});



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
