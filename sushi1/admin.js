let siteConfig = {};

// Load configuration
async function loadConfig() {
    try {
        const response = await fetch('site-config.json');
        siteConfig = await response.json();
        populateForm();
    } catch (error) {
        console.error('Error loading configuration:', error);
    }
}

// Populate form with current configuration
function populateForm() {
    // Site settings
    document.getElementById('site-title').value = siteConfig.site.title;
    document.getElementById('site-logo').value = siteConfig.site.logo;
    document.getElementById('site-brand').value = siteConfig.site.brand;

    // Hero section
    document.getElementById('hero-title-highlight').value = siteConfig.hero.titleHighlight;
    document.getElementById('hero-subtitle').value = siteConfig.hero.subtitle;
    document.getElementById('hero-button-1-text').value = siteConfig.hero.buttons[0].text;
    document.getElementById('hero-button-1-href').value = siteConfig.hero.buttons[0].href;
    document.getElementById('hero-button-2-text').value = siteConfig.hero.buttons[1].text;
    document.getElementById('hero-button-2-href').value = siteConfig.hero.buttons[1].href;

    // Gallery section
    document.getElementById('gallery-title').value = siteConfig.gallery.title;
    document.getElementById('gallery-subtitle').value = siteConfig.gallery.subtitle;
    populateGalleryItems();

    // Testimonials section
    document.getElementById('testimonials-title').value = siteConfig.testimonials.title;
    document.getElementById('testimonials-subtitle').value = siteConfig.testimonials.subtitle;
    populateTestimonials();

    // Contact section
    document.getElementById('contact-title').value = siteConfig.contact.title;
    document.getElementById('contact-subtitle').value = siteConfig.contact.subtitle;
    document.getElementById('contact-address').value = siteConfig.contact.info.address.value;
    document.getElementById('contact-phone').value = siteConfig.contact.info.phone.value;
    document.getElementById('contact-email').value = siteConfig.contact.info.email.value;
    document.getElementById('contact-hours').value = siteConfig.contact.info.hours.value;

    // Navigation
    populateNavigation();
}

// Populate navigation items
function populateNavigation() {
    const desktopContainer = document.getElementById('navigation-items');
    const mobileContainer = document.getElementById('mobile-navigation-items');
    
    if (desktopContainer) {
        desktopContainer.innerHTML = '';
        
        siteConfig.navigation.items.forEach((item, index) => {
            const template = document.getElementById('nav-item-template');
            const clone = template.content.cloneNode(true);
            
            clone.querySelector('.nav-text').value = item.text;
            clone.querySelector('.nav-href').value = item.href;
            
            clone.querySelector('.remove-nav-item').addEventListener('click', () => {
                siteConfig.navigation.items.splice(index, 1);
                populateNavigation();
            });
            
            desktopContainer.appendChild(clone);
        });
    }
}

// Populate gallery items
function populateGalleryItems() {
    const container = document.getElementById('gallery-items');
    container.innerHTML = '';
    
    siteConfig.gallery.items.forEach((item, index) => {
        const template = document.getElementById('gallery-item-template');
        const clone = template.content.cloneNode(true);
        
        clone.querySelector('.gallery-name').value = item.name;
        clone.querySelector('.gallery-description').value = item.description;
        clone.querySelector('.gallery-price').value = item.price;
        clone.querySelector('.gallery-tag').value = item.tag;
        clone.querySelector('.gallery-emoji').value = item.emoji;
        
        clone.querySelector('.remove-gallery-item').addEventListener('click', () => {
            siteConfig.gallery.items.splice(index, 1);
            populateGalleryItems();
        });
        
        container.appendChild(clone);
    });
}

// Populate testimonials
function populateTestimonials() {
    const container = document.getElementById('testimonial-items');
    container.innerHTML = '';
    
    siteConfig.testimonials.items.forEach((item, index) => {
        const template = document.getElementById('testimonial-template');
        const clone = template.content.cloneNode(true);
        
        clone.querySelector('.testimonial-name').value = item.name;
        clone.querySelector('.testimonial-role').value = item.role;
        clone.querySelector('.testimonial-content').value = item.content;
        clone.querySelector('.testimonial-initial').value = item.initial;
        clone.querySelector('.testimonial-rating').value = item.rating;
        
        clone.querySelector('.remove-testimonial').addEventListener('click', () => {
            siteConfig.testimonials.items.splice(index, 1);
            populateTestimonials();
        });
        
        container.appendChild(clone);
    });
}

// Tab navigation
document.querySelectorAll('.nav-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        const targetTab = tab.getAttribute('data-tab');
        
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.nav-tab').forEach(t => {
            t.classList.remove('bg-gray-100');
        });
        
        // Show target tab content
        document.getElementById(`${targetTab}-tab`).classList.remove('hidden');
        tab.classList.add('bg-gray-100');
    });
});

// Add navigation item
document.getElementById('add-nav-item').addEventListener('click', () => {
    siteConfig.navigation.items.push({
        id: 'new-item',
        text: 'New Item',
        href: '#'
    });
    populateNavigation();
});

// Add gallery item
document.getElementById('add-gallery-item').addEventListener('click', () => {
    siteConfig.gallery.items.push({
        id: 'new-item',
        name: 'New Item',
        description: 'Description',
        price: '$0',
        tag: 'New',
        emoji: '🍽️',
        color: 'gray'
    });
    populateGalleryItems();
});

// Add testimonial
document.getElementById('add-testimonial').addEventListener('click', () => {
    siteConfig.testimonials.items.push({
        id: 'new-testimonial',
        name: 'New Customer',
        role: 'Customer',
        content: 'Great experience!',
        rating: 5,
        initial: 'N'
    });
    populateTestimonials();
});

// Save configuration
async function saveConfig() {
    // Update configuration from form values
    updateConfigFromForm();
    
    try {
        const response = await fetch('save-config.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(siteConfig)
        });
        
        if (response.ok) {
            alert('Configuration saved successfully!');
        } else {
            alert('Error saving configuration');
        }
    } catch (error) {
        console.error('Error saving configuration:', error);
        alert('Error saving configuration');
    }
}

// Update configuration from form values
function updateConfigFromForm() {
    // Site settings
    siteConfig.site.title = document.getElementById('site-title').value;
    siteConfig.site.logo = document.getElementById('site-logo').value;
    siteConfig.site.brand = document.getElementById('site-brand').value;

    // Hero section
    siteConfig.hero.titleHighlight = document.getElementById('hero-title-highlight').value;
    siteConfig.hero.subtitle = document.getElementById('hero-subtitle').value;
    siteConfig.hero.buttons[0].text = document.getElementById('hero-button-1-text').value;
    siteConfig.hero.buttons[0].href = document.getElementById('hero-button-1-href').value;
    siteConfig.hero.buttons[1].text = document.getElementById('hero-button-2-text').value;
    siteConfig.hero.buttons[1].href = document.getElementById('hero-button-2-href').value;

    // Gallery section
    siteConfig.gallery.title = document.getElementById('gallery-title').value;
    siteConfig.gallery.subtitle = document.getElementById('gallery-subtitle').value;
    
    // Update gallery items from form
    const galleryItems = [];
    document.querySelectorAll('.gallery-item').forEach((item, index) => {
        galleryItems.push({
            id: siteConfig.gallery.items[index]?.id || `item-${index}`,
            name: item.querySelector('.gallery-name').value,
            description: item.querySelector('.gallery-description').value,
            price: item.querySelector('.gallery-price').value,
            tag: item.querySelector('.gallery-tag').value,
            emoji: item.querySelector('.gallery-emoji').value,
            color: siteConfig.gallery.items[index]?.color || 'gray'
        });
    });
    siteConfig.gallery.items = galleryItems;

    // Testimonials section
    siteConfig.testimonials.title = document.getElementById('testimonials-title').value;
    siteConfig.testimonials.subtitle = document.getElementById('testimonials-subtitle').value;
    
    // Update testimonials from form
    const testimonialItems = [];
    document.querySelectorAll('.testimonial-item').forEach((item, index) => {
        testimonialItems.push({
            id: siteConfig.testimonials.items[index]?.id || `testimonial-${index}`,
            name: item.querySelector('.testimonial-name').value,
            role: item.querySelector('.testimonial-role').value,
            content: item.querySelector('.testimonial-content').value,
            initial: item.querySelector('.testimonial-initial').value,
            rating: parseInt(item.querySelector('.testimonial-rating').value)
        });
    });
    siteConfig.testimonials.items = testimonialItems;

    // Contact section
    siteConfig.contact.title = document.getElementById('contact-title').value;
    siteConfig.contact.subtitle = document.getElementById('contact-subtitle').value;
    siteConfig.contact.info.address.value = document.getElementById('contact-address').value;
    siteConfig.contact.info.phone.value = document.getElementById('contact-phone').value;
    siteConfig.contact.info.email.value = document.getElementById('contact-email').value;
    siteConfig.contact.info.hours.value = document.getElementById('contact-hours').value;

    // Navigation
    const navItems = [];
    document.querySelectorAll('.nav-item').forEach((item, index) => {
        navItems.push({
            id: siteConfig.navigation.items[index]?.id || `nav-${index}`,
            text: item.querySelector('.nav-text').value,
            href: item.querySelector('.nav-href').value
        });
    });
    siteConfig.navigation.items = navItems;
}

// Event listeners
document.getElementById('save-btn').addEventListener('click', saveConfig);
document.getElementById('preview-btn').addEventListener('click', () => {
    window.open('index.html', '_blank');
});

// Load configuration on page load
document.addEventListener('DOMContentLoaded', loadConfig); 