let forms = document.querySelectorAll('form[data-ajax-send]');

forms.forEach(function (form) {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let submitBtn = form.querySelector("button[type='submit'], input[type='submit']");
        if (!submitBtn) return;

        submitBtn.disabled = true;

        // required validation
        let requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(function (field) {
            let parent = field.parentElement;
            if (!field.value.trim()) {
                if (parent) parent.classList.add('error');
                isValid = false;
            } else {
                if (parent) parent.classList.remove('error');
            }
        });

        if (!isValid) {
            submitBtn.disabled = false;
            return;
        }

        if (typeof ajaxurl_object === 'undefined' || !ajaxurl_object.ajaxurl) {
            console.error('ajaxurl_object.ajaxurl не определён');
            submitBtn.disabled = false;
            return;
        }

        let fd = new FormData(form);

        // Маркер: только такие запросы обработает send.php
        fd.append('perspectiva_form', '1');

        fetch(ajaxurl_object.ajaxurl + '?action=sendOrder', {
            method: 'POST',
            body: fd
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (!data || !data.success) {
                    let msg = data && data.data && data.data.message ? data.data.message : data;
                    console.error('Ошибка:', msg);
                    return;
                }

                form.reset();

                if (typeof closeAllPopups === 'function') {
                    closeAllPopups();
                }
            })
            .catch(function (err) {
                console.error('Ошибка запроса:', err);
            })
            .finally(function () {
                submitBtn.disabled = false;
            });
    });
});