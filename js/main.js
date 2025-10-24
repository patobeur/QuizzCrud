document.addEventListener('DOMContentLoaded', () => {
    // Burger menu logic
    const burgerMenu = document.getElementById('burger-menu');
    const navLinks = document.getElementById('nav-links');

    if (burgerMenu && navLinks) {
        burgerMenu.addEventListener('click', () => {
            navLinks.classList.toggle('hidden');
            navLinks.classList.toggle('flex');
            navLinks.classList.add('flex-col', 'absolute', 'top-16', 'left-0', 'right-0', 'bg-white', 'shadow-lg', 'p-6', 'lg:hidden');
        });
    }

    // Dropdown menu logic
    const dropdowns = [
        { button: 'tests-menu-button', dropdown: 'tests-menu-dropdown' },
        { button: 'profile-menu-button', dropdown: 'profile-menu-dropdown' }
    ];

    dropdowns.forEach(item => {
        const button = document.getElementById(item.button);
        const dropdown = document.getElementById(item.dropdown);

        if (button && dropdown) {
            button.addEventListener('click', (event) => {
                event.stopPropagation();
                // Close other dropdowns
                dropdowns.forEach(other => {
                    if (other.dropdown !== item.dropdown) {
                        document.getElementById(other.dropdown).classList.add('hidden');
                    }
                });
                dropdown.classList.toggle('hidden');
            });
        }
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
        dropdowns.forEach(item => {
            const button = document.getElementById(item.button);
            const dropdown = document.getElementById(item.dropdown);
            if (dropdown && !dropdown.classList.contains('hidden') && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
});
