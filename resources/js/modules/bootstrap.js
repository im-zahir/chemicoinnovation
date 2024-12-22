/**
 * Initialize Bootstrap components
 */
export const initializeBootstrapComponents = () => {
    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Initialize popovers
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));

    // Initialize toasts
    const toastElList = document.querySelectorAll('.toast');
    [...toastElList].map(toastEl => new bootstrap.Toast(toastEl));

    // Initialize collapse elements
    const collapseElementList = document.querySelectorAll('.collapse');
    [...collapseElementList].map(collapseEl => new bootstrap.Collapse(collapseEl, {
        toggle: false
    }));

    // Add loading spinners to buttons when clicked
    document.querySelectorAll('[data-loading]').forEach(button => {
        button.addEventListener('click', () => {
            const loadingText = button.getAttribute('data-loading') || 'Loading...';
            const originalHtml = button.innerHTML;
            
            button.disabled = true;
            button.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                ${loadingText}
            `;

            // Reset button after timeout (if needed)
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = originalHtml;
            }, 30000); // 30 second timeout
        });
    });
};
