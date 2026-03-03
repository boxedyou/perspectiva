function showCookie () {
    const cookieBanner = document.querySelector('[data-cookie]');
    const closeButton = document.querySelector('[data-cookie-close]');

    if (!cookieBanner || !closeButton) return;

    const cookieName = 'saveCookiePopup';

    if (getCookie(cookieName)) {
        cookieBanner.style.display = 'none';
    } else {
        cookieBanner.style.display = 'block';

        closeButton.addEventListener('click', function () {
            setCookie(cookieName, 'true', 30);
            cookieBanner.style.display = 'none';
        });
    }

}

showCookie ()
