(function () {
    'use strict';

    function getScrollbarWidth() {
        return window.innerWidth - document.documentElement.clientWidth;
    }

    function lockScroll() {
        document.documentElement.style.marginRight = getScrollbarWidth() + 'px';
        document.documentElement.style.overflow = document.body.style.overflow = 'hidden';
    }

    function unlockScroll() {
        document.documentElement.style.marginRight = document.documentElement.style.overflow = document.body.style.overflow = '';
    }

    function openPopup(popup) {
        if (!popup) return;
        popup.classList.add('is-open');
        popup.setAttribute('aria-hidden', 'false');
        lockScroll();

        if (popup.matches('[data-popup-request]')) {
            let form = popup.querySelector('form');
            if (form) form.setAttribute('data-form-request', '');
        }
    }

    function closeAllPopups() {
        document.querySelectorAll('[data-popup].is-open').forEach(function (p) {
            p.classList.remove('is-open');
            p.setAttribute('aria-hidden', 'true');
        });
        unlockScroll();
    }

    let openByTrigger = {
        'data-color-popup-open': '[data-popup-ral]',
        'data-popup-request-open': '[data-popup-request]',
        'data-callback-popup-open': '[data-popup-callback]'
    };

    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-popup-close]')) {
            e.preventDefault();
            closeAllPopups();
            return;
        }
        let popup = e.target.closest('[data-popup]');
        if (popup && !e.target.closest('[data-popup-inner]')) {
            closeAllPopups();
            return;
        }
        for (let trigger in openByTrigger) {
            if (e.target.closest('[' + trigger + ']')) {
                e.preventDefault();
                openPopup(document.querySelector(openByTrigger[trigger]));
                break;
            }
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeAllPopups();
    });
})();