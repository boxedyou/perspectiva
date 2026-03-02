(function () {
    'use strict';

    document.addEventListener('click', function (e) {
        let item = e.target.closest('[data-size]');
        if (!item) return;

        let parent = item.closest('[data-size-parent]');
        if (!parent) return;

        parent.querySelectorAll('[data-size]').forEach(function (el) {
            el.classList.remove('active');
        });
        item.classList.add('active');
    });
})();