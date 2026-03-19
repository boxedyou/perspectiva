(function () {
    'use strict';

    function getColorFromItem(item) {
        let colorEl = item.querySelector('.popup-ral__list-color');
        if (!colorEl || !colorEl.style.background) return '';
        let bg = colorEl.style.background;
        // поддержка rgb/rgba и hex
        let hexMatch = bg.match(/#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})\b/);
        if (hexMatch) return '#' + hexMatch[1];
        let rgbMatch = bg.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
        if (rgbMatch) {
            let r = ('0' + parseInt(rgbMatch[1], 10).toString(16)).slice(-2);
            let g = ('0' + parseInt(rgbMatch[2], 10).toString(16)).slice(-2);
            let b = ('0' + parseInt(rgbMatch[3], 10).toString(16)).slice(-2);
            return '#' + r + g + b;
        }
        return '';
    }

    function getRalNameFromItem(item) {
        return item.getAttribute('data-ral') || (item.querySelector('.popup-ral__list-item-text') && item.querySelector('.popup-ral__list-item-text').textContent.trim()) || '';
    }

    document.addEventListener('click', function (e) {
        let item = e.target.closest('.popup-ral__list-item');
        if (!item) return;

        let color = getColorFromItem(item);
        let ralName = getRalNameFromItem(item);

        // Записать цвет в data-color-choose (атрибут и фон)
        let colorTarget = document.querySelector('[data-color-choose]');
        if (colorTarget) {
            colorTarget.setAttribute('data-color-choose', color);
            colorTarget.style.background = color || '';
        }

        // Записать название RAL в data-ral-name
        document.querySelectorAll('[data-ral-name]').forEach(function (el) {
            el.textContent = ralName;
        });

        // Снять active с соседей, повесить на выбранный
        let list = item.closest('.popup-ral__list');
        if (list) {
            list.querySelectorAll('.popup-ral__list-item').forEach(function (li) {
                li.classList.remove('active');
            });
            item.classList.add('active');
            closeAllPopups();
        }
    });
})();