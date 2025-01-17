const buttons = document.querySelectorAll('[data-tab-target]');
const tabs = document.querySelectorAll('[data-tab-id]');

// Get the tab from the URL
const url = new URL(window.location.href);
const tab = url.searchParams.get('tab');
if (tab) {
    tabs.forEach(tab => {
        tab.classList.remove('active');
    });
    buttons.forEach(button => {
        button.classList.remove('active');
    });
    document.querySelector(`[data-tab-id="${tab}"]`).classList.add('active');
    document.querySelector(`[data-tab-target="${tab}"]`).classList.add('active');
}

buttons.forEach(button => {
    button.addEventListener('click', () => {

        // Get the target tab
        const target = document.querySelector(`[data-tab-id="${button.dataset.tabTarget}"]`);

        tabs.forEach(tab => {
            tab.classList.remove('active');
        });
        buttons.forEach(button => {
            button.classList.remove('active');
        });
        target.classList.add('active');
        button.classList.add('active');

        // set parameter to active tab
        const url = new URL(window.location.href);
        url.searchParams.set('tab', button.dataset.tabTarget);
        window.history.pushState({}, '', url);
    });
});
