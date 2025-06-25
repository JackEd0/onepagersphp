// Load site configuration
async function loadSiteConfig() {
    try {
        const response = await fetch('site-config.json');
        const config = await response.json();
        applySiteConfig(config);
    } catch (error) {
        console.error('Error loading site configuration:', error);
    }
}

// Apply site configuration to the page
function applySiteConfig(config) {
    // Site title
    document.querySelector('[data-config-selector="site-title"]').textContent = config.site.title;
    document.querySelector('[data-config-selector="site-logo"]').textContent = config.site.logo;
    document.querySelector('[data-config-selector="site-brand"]').textContent = config.site.brand;
    document.querySelector('[data-config-selector="footer-logo"]').textContent = config.site.logo;
    document.querySelector('[data-config-selector="footer-brand"]').textContent = config.site.brand;

    // Navigation
    const desktopNavContainer = document.getElementById('navigation-items');
    const mobileNavContainer = document.getElementById('mobile-navigation-items');
    
    if (desktopNavContainer && mobileNavContainer) {
        // Clear existing navigation
        desktopNavContainer.innerHTML = '';
        mobileNavContainer.innerHTML = '';
        
        // Populate navigation items
        config.navigation.items.forEach((item) => {
            // Create desktop navigation item
            const desktopLink = document.createElement('a');
            desktopLink.href = item.href;
            desktopLink.className = 'text-sushi-dark hover:text-sushi-red transition-colors duration-200';
            desktopLink.textContent = item.text;
            desktopNavContainer.appendChild(desktopLink);
            
            // Create mobile navigation item
            const mobileLink = document.createElement('a');
            mobileLink.href = item.href;
            mobileLink.className = 'text-sushi-dark hover:text-sushi-red transition-colors duration-200';
            mobileLink.textContent = item.text;
            mobileNavContainer.appendChild(mobileLink);
        });
    }

    // Hero section
    const heroTitle = document.querySelector('[data-config-selector="hero-title"]');
    if (heroTitle) {
        heroTitle.innerHTML = `Experience <span class="text-sushi-red" data-config-selector="hero-title-highlight">${config.hero.titleHighlight}</span> Japanese Cuisine`;
    }
    document.querySelector('[data-config-selector="hero-subtitle"]').textContent = config.hero.subtitle;
    
    config.hero.buttons.forEach((button, index) => {
        const buttonElement = document.querySelector(`[data-config-selector="hero-button-${index + 1}"]`);
        if (buttonElement) {
            buttonElement.textContent = button.text;
            buttonElement.href = button.href;
        }
    });

    // Gallery section
    document.querySelector('[data-config-selector="gallery-title"]').textContent = config.gallery.title;
    document.querySelector('[data-config-selector="gallery-subtitle"]').textContent = config.gallery.subtitle;

    config.gallery.items.forEach((item, index) => {
        const itemIndex = index + 1;
        document.querySelector(`[data-config-selector="gallery-item-${itemIndex}-name"]`).textContent = item.name;
        document.querySelector(`[data-config-selector="gallery-item-${itemIndex}-description"]`).textContent = item.description;
        document.querySelector(`[data-config-selector="gallery-item-${itemIndex}-price"]`).textContent = item.price;
        document.querySelector(`[data-config-selector="gallery-item-${itemIndex}-tag"]`).textContent = item.tag;
        document.querySelector(`[data-config-selector="gallery-item-${itemIndex}-emoji"]`).textContent = item.emoji;
    });

    // Testimonials section
    document.querySelector('[data-config-selector="testimonials-title"]').textContent = config.testimonials.title;
    document.querySelector('[data-config-selector="testimonials-subtitle"]').textContent = config.testimonials.subtitle;

    config.testimonials.items.forEach((testimonial, index) => {
        const itemIndex = index + 1;
        document.querySelector(`[data-config-selector="testimonial-${itemIndex}-content"]`).textContent = `"${testimonial.content}"`;
        document.querySelector(`[data-config-selector="testimonial-${itemIndex}-name"]`).textContent = testimonial.name;
        document.querySelector(`[data-config-selector="testimonial-${itemIndex}-role"]`).textContent = testimonial.role;
        document.querySelector(`[data-config-selector="testimonial-${itemIndex}-initial"]`).textContent = testimonial.initial;
    });

    // Contact section
    document.querySelector('[data-config-selector="contact-title"]').textContent = config.contact.title;
    document.querySelector('[data-config-selector="contact-subtitle"]').textContent = config.contact.subtitle;
    document.querySelector('[data-config-selector="reservation-title"]').textContent = config.contact.reservation.title;

    // Contact info
    document.querySelector('[data-config-selector="contact-address-label"]').textContent = config.contact.info.address.label;
    document.querySelector('[data-config-selector="contact-address-value"]').innerHTML = config.contact.info.address.value.replace('\n', '<br>');
    document.querySelector('[data-config-selector="contact-phone-label"]').textContent = config.contact.info.phone.label;
    document.querySelector('[data-config-selector="contact-phone-value"]').textContent = config.contact.info.phone.value;
    document.querySelector('[data-config-selector="contact-email-label"]').textContent = config.contact.info.email.label;
    document.querySelector('[data-config-selector="contact-email-value"]').textContent = config.contact.info.email.value;
    document.querySelector('[data-config-selector="contact-hours-label"]').textContent = config.contact.info.hours.label;
    document.querySelector('[data-config-selector="contact-hours-value"]').innerHTML = config.contact.info.hours.value.replace('\n', '<br>');

    // Footer
    document.querySelector('[data-config-selector="footer-description"]').textContent = config.footer.description;
    document.querySelector('[data-config-selector="footer-hours-weekdays"]').textContent = config.footer.hours.weekdays;
    document.querySelector('[data-config-selector="footer-hours-sunday"]').textContent = config.footer.hours.sunday;
    document.querySelector('[data-config-selector="footer-copyright"]').textContent = config.footer.copyright;
}

// Load configuration when page loads
document.addEventListener('DOMContentLoaded', loadSiteConfig);

// Mobile menu toggle
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

mobileMenuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
        // Close mobile menu if open
        mobileMenu.classList.add('hidden');
    });
});

// Header scroll effect
window.addEventListener('scroll', () => {
    const header = document.getElementById('header');
    if (window.scrollY > 100) {
        header.classList.add('shadow-lg');
    } else {
        header.classList.remove('shadow-lg');
    }
});

// Form submission
const reservationForm = document.querySelector('form');
reservationForm.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('Thank you for your reservation request! We will contact you shortly to confirm.');
    reservationForm.reset();
}); 