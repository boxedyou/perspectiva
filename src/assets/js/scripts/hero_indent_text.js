// Установка отступа в зависимости от высоты текста
function setTextIndent() {
    const indentElements = document.querySelectorAll('[data-text-indent]');
    console.log('Найдено элементов с data-text-indent:', indentElements.length);

    indentElements.forEach((indentEl) => {
        const parent = indentEl.closest('.hero__link');
        if (!parent) {
            console.log('Родитель .hero__link не найден');
            return;
        }

        const anchorEl = parent.querySelector('[data-text-anchor]');
        if (!anchorEl) {
            console.log('Элемент с data-text-anchor не найден в родителе');
            return;
        }

        const height = anchorEl.offsetHeight;
        console.log('Высота anchor элемента:', height);

        if (height > 0) {
            indentEl.style.marginBottom = height + 'px';
            console.log('Отступ установлен:', height + 'px');
        } else {
            console.warn('Высота элемента равна 0, возможно стили еще не применены');
        }
    });
}

// Инициализация после загрузки DOM и стилей
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        // Небольшая задержка для применения стилей
        setTimeout(setTextIndent, 100);
    });
} else {
    // DOM уже загружен
    setTimeout(setTextIndent, 100);
}

// Обновление при изменении размера окна
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(setTextIndent, 100);
});

// Отслеживание изменений высоты текста
if (window.ResizeObserver) {
    const heroTextIndentResizeObserver = new ResizeObserver(() => {
        setTextIndent();
    });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-text-anchor]').forEach(el => {
            heroTextIndentResizeObserver.observe(el);
        });
    });
}

