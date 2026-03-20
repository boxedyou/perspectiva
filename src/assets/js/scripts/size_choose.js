(function () {
    'use strict';

    function syncPrices(sizeParent) {
        const card = sizeParent.closest('.single-category-hero__item');
        if (!card) return;

        const activeSize = sizeParent.querySelector('[data-size].active');
        if (!activeSize) return;

        const sizeName = activeSize.getAttribute('data-size-name') || '';

        const prices = card.querySelectorAll('.single-category-hero__price');
        prices.forEach(function (p) {
            const pName = p.getAttribute('data-size-name') || '';
            p.classList.toggle('active', pName === sizeName);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-size-parent]').forEach(function (parent) {
            syncPrices(parent);
        });
    });

    document.addEventListener('click', function (e) {
        let item = e.target.closest('[data-size]');
        if (!item) return;

        let parent = item.closest('[data-size-parent]');
        if (!parent) return;

        parent.querySelectorAll('[data-size]').forEach(function (el) {
            el.classList.remove('active');
        });

        item.classList.add('active');
        syncPrices(parent);
    });
})();