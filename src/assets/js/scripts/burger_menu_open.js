const $burgerMenuOpen = document.querySelector('[data-burger-menu-open]');
const $burgerMenuClose = document.querySelector('[data-burger-menu-close]');
const $burgerMenu = document.querySelector('[data-burger-menu]');
const $header = document.querySelector('[data-header]');

function setMenuOpen(isOpen) {
    $burgerMenu.classList.toggle('active', isOpen);
    $header.classList.toggle('burger-menu-active', isOpen);
    $burgerMenuOpen.style.display = isOpen ? 'none' : 'block';
    $burgerMenuClose.style.display = isOpen ? 'block' : 'none';
    isOpen ? lockScroll() : unlockScroll();
}

$burgerMenuOpen.addEventListener('click', () => setMenuOpen(true));
$burgerMenuClose.addEventListener('click', () => setMenuOpen(false));

