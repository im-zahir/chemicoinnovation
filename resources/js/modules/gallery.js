/**
 * Product gallery functionality
 */
export const initializeGallery = () => {
    const productImages = document.querySelectorAll('.product-gallery img');
    const modalImage = document.getElementById('modalImage');
    
    if (!productImages.length || !modalImage) return;

    // Initialize lightbox for gallery images
    productImages.forEach(image => {
        image.addEventListener('click', () => {
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            modalImage.src = image.dataset.fullsize || image.src;
            modalImage.alt = image.alt;
            modal.show();
        });
    });

    // Image zoom functionality
    let zoom = 1;
    const ZOOM_SPEED = 0.1;

    document.querySelector('.zoom-in')?.addEventListener('click', () => {
        zoom += ZOOM_SPEED;
        modalImage.style.transform = `scale(${zoom})`;
    });

    document.querySelector('.zoom-out')?.addEventListener('click', () => {
        if (zoom > 1) {
            zoom -= ZOOM_SPEED;
            modalImage.style.transform = `scale(${zoom})`;
        }
    });

    // Reset zoom when modal closes
    document.getElementById('imageModal')?.addEventListener('hidden.bs.modal', () => {
        zoom = 1;
        modalImage.style.transform = '';
    });

    // Keyboard navigation for gallery
    document.addEventListener('keydown', (e) => {
        const modal = document.getElementById('imageModal');
        if (!modal?.classList.contains('show')) return;

        const currentSrc = modalImage.src;
        const currentIndex = Array.from(productImages).findIndex(img => 
            (img.dataset.fullsize || img.src) === currentSrc
        );

        if (e.key === 'ArrowRight' && currentIndex < productImages.length - 1) {
            const nextImage = productImages[currentIndex + 1];
            modalImage.src = nextImage.dataset.fullsize || nextImage.src;
            modalImage.alt = nextImage.alt;
        } else if (e.key === 'ArrowLeft' && currentIndex > 0) {
            const prevImage = productImages[currentIndex - 1];
            modalImage.src = prevImage.dataset.fullsize || prevImage.src;
            modalImage.alt = prevImage.alt;
        }
    });
};
