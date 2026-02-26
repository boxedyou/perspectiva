// Перенос элементов с сохранением исходного порядка
function moveElementsOnResize() {
    const startParent = document.querySelector('[data-start-parent]');
    const endParent = document.querySelector('[data-end-parent]');

    if (!startParent || !endParent) {
        return;
    }

    const breakpoint = 1100;
    const windowWidth = window.innerWidth;

    // Сохраняем исходный порядок элементов только один раз
    if (!window.moveElementsOrder) {
        // Сохраняем все дочерние элементы startParent в исходном порядке
        const allChildren = Array.from(startParent.children);
        window.moveElementsOrder = allChildren.map((child, index) => {
            return {
                element: child,
                originalIndex: index,
                hasDataMove: child.hasAttribute('data-move'),
                nextSibling: child.nextSibling // Сохраняем следующий сосед
            };
        });
    }

    if (windowWidth <= breakpoint) {
        // Переносим элементы с data-move в конец endParent
        window.moveElementsOrder.forEach(({ element, hasDataMove }) => {
            if (hasDataMove && startParent.contains(element)) {
                endParent.appendChild(element);
            }
        });
    } else {
        // Возвращаем элементы в исходное положение в startParent
        // Сортируем по исходному индексу (от меньшего к большему)
        const elementsToReturn = window.moveElementsOrder
            .filter(({ element, hasDataMove }) =>
                hasDataMove &&
                endParent.contains(element) &&
                !startParent.contains(element)
            )
            .sort((a, b) => a.originalIndex - b.originalIndex);

        elementsToReturn.forEach(({ element, originalIndex, nextSibling }) => {
            // Пытаемся использовать сохраненный nextSibling
            if (nextSibling && nextSibling.parentNode === startParent) {
                startParent.insertBefore(element, nextSibling);
            } else {
                // Если nextSibling не найден, ищем элемент с индексом originalIndex + 1
                const nextOriginalElement = window.moveElementsOrder.find(
                    item => item.originalIndex === originalIndex + 1 &&
                        startParent.contains(item.element)
                );

                if (nextOriginalElement) {
                    startParent.insertBefore(element, nextOriginalElement.element);
                } else {
                    // Если не нашли следующий элемент, ищем последний элемент без data-move
                    const allChildren = Array.from(startParent.children);
                    const lastNonMoveElement = allChildren.findLast(child => !child.hasAttribute('data-move'));

                    if (lastNonMoveElement) {
                        // Вставляем после последнего элемента без data-move
                        startParent.insertBefore(element, lastNonMoveElement.nextSibling);
                    } else {
                        // Если нет элементов без data-move, добавляем в конец
                        startParent.appendChild(element);
                    }
                }
            }
        });
    }
}

// Инициализация
function initMoveElements() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(moveElementsOnResize, 100);
        });
    } else {
        setTimeout(moveElementsOnResize, 100);
    }
}

initMoveElements();

// Обновление при изменении размера
let resizeTimerElement;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimerElement);
    resizeTimerElement = setTimeout(moveElementsOnResize, 150);
});