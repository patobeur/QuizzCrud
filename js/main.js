document.addEventListener('DOMContentLoaded', () => {
    const burgerMenu = document.getElementById('burger-menu');
    const navLinks = document.getElementById('nav-links');

    if (burgerMenu && navLinks) {
        burgerMenu.addEventListener('click', () => {
            navLinks.classList.toggle('hidden');
            navLinks.classList.toggle('flex');
            navLinks.classList.add('flex-col', 'absolute', 'top-16', 'left-0', 'right-0', 'bg-white', 'shadow-lg', 'p-6', 'lg:hidden');
        });
    }
});