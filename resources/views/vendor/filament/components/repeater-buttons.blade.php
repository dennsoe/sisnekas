@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function initRepeaterControls() {
        const repeater = document.querySelector('.repeater-riwayat-pendidikan');
        if (!repeater) return;

        // Create buttons container
        const controlsContainer = document.createElement('div');
        controlsContainer.className = 'flex items-center gap-3 mb-3';

        // Create collapse all button
        const collapseAllBtn = document.createElement('button');
        collapseAllBtn.type = 'button';
        collapseAllBtn.className = 'fi-btn fi-btn-size-sm fi-btn-color-gray relative inline-flex items-center justify-center font-semibold outline-none transition duration-75 hover:bg-gray-50 focus:bg-gray-50 dark:hover:bg-white/5 dark:focus:bg-white/5 fi-color-gray gap-1.5 px-3 py-2 text-sm text-gray-700 dark:text-gray-200 fi-ac-btn-action rounded-lg';
        collapseAllBtn.innerHTML = `
            <svg class="fi-icon-btn-icon h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M6.3 10.3a1 1 0 0 1 1.4 0l3.3 3.29 3.3-3.3a1 1 0 1 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 0-1.42z"/>
            </svg>
            <span class="ml-1">Sembunyikan Semua</span>
        `;

        // Create expand all button
        const expandAllBtn = document.createElement('button');
        expandAllBtn.type = 'button';
        expandAllBtn.className = 'fi-btn fi-btn-size-sm fi-btn-color-gray relative inline-flex items-center justify-center font-semibold outline-none transition duration-75 hover:bg-gray-50 focus:bg-gray-50 dark:hover:bg-white/5 dark:focus:bg-white/5 fi-color-gray gap-1.5 px-3 py-2 text-sm text-gray-700 dark:text-gray-200 fi-ac-btn-action rounded-lg';
        expandAllBtn.innerHTML = `
            <svg class="fi-icon-btn-icon h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M13.7 9.7a1 1 0 0 1-1.4 0L9 6.41l-3.3 3.3a1 1 0 0 1-1.4-1.42l4-4a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.42z"/>
            </svg>
            <span class="ml-1">Tampilkan Semua</span>
        `;

        // Add event listeners
        collapseAllBtn.addEventListener('click', () => {
            repeater.querySelectorAll('[data-repeater-collapse-trigger]').forEach(trigger => {
                const item = trigger.closest('[data-repeater-item]');
                if (!item.classList.contains('collapsed')) {
                    trigger.click();
                }
            });
        });

        expandAllBtn.addEventListener('click', () => {
            repeater.querySelectorAll('[data-repeater-collapse-trigger]').forEach(trigger => {
                const item = trigger.closest('[data-repeater-item]');
                if (item.classList.contains('collapsed')) {
                    trigger.click();
                }
            });
        });

        // Add buttons to container
        controlsContainer.appendChild(expandAllBtn);
        controlsContainer.appendChild(collapseAllBtn);

        // Insert controls before repeater
        repeater.parentNode.insertBefore(controlsContainer, repeater);
    }

    // Initialize controls
    initRepeaterControls();

    // Re-initialize controls when Livewire updates the DOM
    document.addEventListener('livewire:navigated', initRepeaterControls);
    document.addEventListener('livewire:navigating', initRepeaterControls);
});
</script>
@endpush
