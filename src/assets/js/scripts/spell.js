(function () {
const elements = document.querySelectorAll('[data-spell]');
const constantTime = 1500; // Константа времени в миллисекундах

const startCounting = (element) => {
    const max = +element.getAttribute('max');
    const stepTime = constantTime / max;
    let currentCount = 0;
    const startTime = performance.now();

    const formatNumber = (num) => {
        const str = num.toString();
        return str.length > 4 ? num.toLocaleString('ru-RU') : num;
    };

    const updateCounter = (timestamp) => {
        const elapsedTime = timestamp - startTime;
        const targetCount = Math.min(max, Math.floor((elapsedTime / constantTime) * max));

        if (targetCount > currentCount) {
            element.textContent = formatNumber(targetCount);
            currentCount = targetCount;
        }

        if (currentCount < max) {
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = formatNumber(max);
        }
    };

    requestAnimationFrame(updateCounter);
};

const observerOptionsSpell = {
    root: null,
    rootMargin: '0px',
    threshold: 0.5
};

const observerSpell = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            startCounting(entry.target);
            observer.unobserve(entry.target);
        }
    });
}, observerOptionsSpell);

elements.forEach(element => {
    observerSpell.observe(element);
});
})();