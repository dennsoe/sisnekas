@pushOnce('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function initRepeaterControls() {
        const repeater = document.querySelector('.repeater-riwayat-pendidikan');
        if (!repeater) return;

        // Create buttons container
        const controlsContainer = document.createElement('div');
        controlsContainer.className = 'flex items-center gap-3 mb-3';

        // Create expand all button
        const expandAllBtn = document.createElement('button');
        expandAllBtn.type = 'button';
        expandAllBtn.className = 'fi-btn relative inline-flex items-center justify-center font-semibold outline-none transition duration-75 focus:ring-2 rounded-lg fi-btn-size-md gap-1.5 px-3 py-2 text-sm fi-btn-color-success bg-success-600 text-white hover:bg-success-500 dark:bg-success-500 dark:hover:bg-success-400 focus:ring-success-500/50 dark:focus:ring-success-400/50';
        expandAllBtn.innerHTML = `
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13.7 9.7a1 1 0 0 1-1.4 0L9 6.41l-3.3 3.3a1 1 0 0 1-1.4-1.42l4-4a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.42z"/>
            </svg>
            <span>Tampilkan Semua</span>
        `;

        // Create collapse all button
        const collapseAllBtn = document.createElement('button');
        collapseAllBtn.type = 'button';
        collapseAllBtn.className = 'fi-btn relative inline-flex items-center justify-center font-semibold outline-none transition duration-75 focus:ring-2 rounded-lg fi-btn-size-md gap-1.5 px-3 py-2 text-sm fi-btn-color-danger bg-danger-600 text-white hover:bg-danger-500 dark:bg-danger-500 dark:hover:bg-danger-400 focus:ring-danger-500/50 dark:focus:ring-danger-400/50';
        collapseAllBtn.innerHTML = `
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M6.3 10.3a1 1 0 0 1 1.4 0l3.3 3.29 3.3-3.3a1 1 0 1 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-4-4a1 1 0 0 1 0-1.42z"/>
            </svg>
            <span>Sembunyikan Semua</span>
        `;

        // Add click handlers
        expandAllBtn.addEventListener('click', () => {
            repeater.querySelectorAll('[data-repeater-collapse-trigger]').forEach(trigger => {
                const item = trigger.closest('[data-repeater-item]');
                if (item.classList.contains('collapsed')) {
                    trigger.click();
                }
            });
        });

        collapseAllBtn.addEventListener('click', () => {
            repeater.querySelectorAll('[data-repeater-collapse-trigger]').forEach(trigger => {
                const item = trigger.closest('[data-repeater-item]');
                if (!item.classList.contains('collapsed')) {
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

    // Re-initialize on Livewire updates
    document.addEventListener('livewire:load', initRepeaterControls);
    document.addEventListener('livewire:update', initRepeaterControls);
});
</script>
@endPushOnce
