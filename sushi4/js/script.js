document.addEventListener('DOMContentLoaded', function () {
    const header = document.getElementById('header');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    // Sticky header
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            header.classList.add('header-scrolled');
        } else {
            header.classList.remove('header-scrolled');
        }
    });

    // Mobile menu toggle
    mobileMenuButton.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu when a link is clicked
    const mobileMenuLinks = mobileMenu.getElementsByTagName('a');
    for (let i = 0; i < mobileMenuLinks.length; i++) {
        mobileMenuLinks[i].addEventListener('click', function () {
            mobileMenu.classList.add('hidden');
        });
    }
});
