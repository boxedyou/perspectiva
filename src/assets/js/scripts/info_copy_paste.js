(function () {
    'use strict';

    const HIDDEN_FIELDS = [
        { name: 'Заголовок товара', valueKey: 'title' },
        { name: 'Размер Товара', valueKey: 'size' },
        { name: 'Цвет по RAL', valueKey: 'ral' }
    ];

    function getColorFromChooseEl(el) {
        if (!el) return '';
        let bg = el.style.background || (el && window.getComputedStyle(el).backgroundColor);
        if (!bg) return '';
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

    function setHiddenInputs(form, values) {
        let insertBeforeEl = form.firstElementChild;

        HIDDEN_FIELDS.forEach(function (f) {
            let input = form.querySelector('input[type="hidden"][name="' + f.name + '"]');
            let value = values[f.valueKey] || '';

            if (input) {
                input.value = value;
                insertBeforeEl = input.nextElementSibling;
            } else {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = f.name;
                input.value = value;
                form.insertBefore(input, insertBeforeEl);
                insertBeforeEl = input.nextElementSibling;
            }
        });
    }

    function fillRequestPopup(scope) {
        scope = scope || document;

        let sizeParent = scope.querySelector('[data-size-parent]');
        let activeSizeEl = sizeParent ? sizeParent.querySelector('[data-size].active') : null;
        let sizeText = activeSizeEl ? activeSizeEl.textContent.trim() : '';

        let colorChooseEl = scope.querySelector('[data-color-choose]');
        getColorFromChooseEl(colorChooseEl);

        let srcCopyBlock = scope.querySelector('[data-src-copy]');
        let imgSrc = '';
        if (srcCopyBlock) {
            let img = srcCopyBlock.querySelector('img');
            if (img && img.src) imgSrc = img.src;
        }

        let itemNameEl = scope.querySelector('[data-item-name]');
        let itemNameText = itemNameEl ? itemNameEl.textContent.trim() : '';

        let ralNameEl = scope.querySelector('[data-ral-name]');
        let ralText = (ralNameEl && ralNameEl.textContent.trim()) ? ralNameEl.textContent.trim() : 'не выбрано';

        let insertImg = document.querySelector('[data-src-insert]');
        if (insertImg && imgSrc) insertImg.src = imgSrc;

        let infoTitle = document.querySelector('[data-info-title]');
        if (infoTitle) infoTitle.textContent = itemNameText || '';

        let infoSize = document.querySelector('[data-info-size]');
        if (infoSize) infoSize.textContent = sizeText || '';

        let infoRal = document.querySelector('[data-info-ral]');
        if (infoRal) infoRal.textContent = ralText;

        let form = document.querySelector('[data-form-request]');
        if (form) {
            setHiddenInputs(form, {
                title: itemNameText,
                size: sizeText,
                ral: ralText
            });
        }
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('[data-info-fill]')) return;

        let scope = e.target.closest('.single-category-hero') || document;
        fillRequestPopup(scope);
    });
})();