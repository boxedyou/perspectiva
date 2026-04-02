const parent = document.querySelector('[data-content-parent]');

if (parent) {
    const openEl = parent.querySelector('[data-content-open]');
    const contentEl = parent.querySelector('[data-content]');

    if (openEl && contentEl) {
        openEl.addEventListener('click', () => {
            contentEl.classList.toggle('active');
            openEl.classList.toggle('active');
        });
    }
}