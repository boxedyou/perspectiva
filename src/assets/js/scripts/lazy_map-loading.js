// ==============================================
// Ленивая загрузка яндекс карты с overlay для блокировки скролла
// ==============================================
let yandexMap = document.querySelectorAll('[data-map]');
let yandexMapTargets = document.querySelectorAll('[data-map-target]');

if (yandexMapTargets.length > 0) {
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 1,
    };

    let changeDomOne = function (entries, observer) {
        entries.forEach(entry => {
            setTimeout(() => {
                entry.target.parentNode.classList.add('loading');

                if (entry.isIntersecting && entry.target.parentNode.classList.contains('loading')) {
                    entry.target.src = entry.target.getAttribute('data-src');

                    entry.target.onload = () => {
                        entry.target.parentNode.classList.remove('loading');
                        entry.target.removeAttribute('data-src');

                        // Убираем фон у родителя с data-map-target
                        let mapTarget = entry.target.closest('[data-map-target]');
                        if (mapTarget) {
                            mapTarget.style.backgroundImage = 'none';
                        }

                        observer.unobserve(entry.target);
                    };
                }
            }, 500);
        });
    };

    let observer = new IntersectionObserver(changeDomOne, options);

    yandexMap.forEach(function (map) {
        map.parentElement.classList.add('loading');

        // Добавляем overlay для блокировки скролла карты
        let mapTarget = map.closest('[data-map-target]');
        if (mapTarget && !mapTarget.querySelector('.map__overlay')) {
            let overlay = document.createElement('div');
            overlay.className = 'map__overlay';
            overlay.style.cssText = `
                position: absolute;
                inset: 0;
                z-index: 2;
                background: transparent;
            `;
            overlay.addEventListener('click', () => {
                overlay.remove(); // Убираем overlay при клике
            });
            mapTarget.style.position = 'relative';
            mapTarget.appendChild(overlay);
        }

        observer.observe(map, {
            childList: true,
            subtree: true,
            characterDataOldValue: false
        });
    });
}
