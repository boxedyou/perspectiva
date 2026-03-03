// Список UTM-меток
const utmParams = ["utm_source", "utm_medium", "utm_campaign", "utm_term", "utm_content"];

// Сохраняем UTM-метки в cookies, если они есть в URL
function saveUTMParametersToCookies() {
    utmParams.forEach(param => {
        const value = getUTMParameter(param);
        if (value) setCookie(param, value, 365);
    });
}

// Добавляем скрытые input'ы с UTM-метками в формы
function addUTMInputsToForms() {
    document.querySelectorAll("form:not(.menu-search__form)").forEach(form => {
        utmParams.forEach(param => {
            let value = getUTMParameter(param) || getCookie(param);
            if (value) {
                let input = form.querySelector(`input[name="${param}"]`);
                if (!input) {
                    input = document.createElement("input");
                    input.type = "hidden";
                    input.name = param;
                    form.appendChild(input);
                }
                input.value = value;
            }
        });
    });
}

// Выполняем функции при загрузке страницы
    saveUTMParametersToCookies(); // Сохранение UTM в cookies
    addUTMInputsToForms(); // Добавление UTM в формы

// Перехватываем динамически добавляемые формы (например, AJAX)
const observer = new MutationObserver(() => {
    addUTMInputsToForms();
});

observer.observe(document.body, { childList: true, subtree: true });