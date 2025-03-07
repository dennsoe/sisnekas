document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('switch-tab', function(event) {
        const tabId = event.detail.tab;
        const tabButton = document.querySelector(`[id^="gtk-tabs"][role="tab"][aria-controls*="${tabId}"]`);
        if (tabButton) {
            tabButton.click();
        }
    });
});