/**
 * index.js
 * This script loads data from site.json and updates the index.html document
 * according to the selectors specified in the JSON file.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Fetch the site.json file
    fetch('./admin/config/site.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load site configuration');
            }
            return response.json();
        })
        .then(data => {
            updateSite(data);
        })
        .catch(error => {
            console.error('Error loading site configuration:', error);
        });
});

/**
 * Update site content based on JSON data
 * @param {Object} data - The site configuration data
 */
function updateSite(data) {
    // Update navigation
    updateNavigation(data.navigation);

    // Update sections
    if (data.sections && Array.isArray(data.sections)) {
        data.sections.forEach(section => {
            updateSection(section);
        });
    }
}

/**
 * Update navigation elements
 * @param {Object} navigationData - The navigation data from site.json
 */
function updateNavigation(navigationData) {
    if (!navigationData) return;

    // Update brand name
    const brandElement = document.querySelector('#brand-logo');
    if (brandElement && navigationData.brand) {
        brandElement.textContent = navigationData.brand;
    }

    // Update navigation items
    if (navigationData.items && Array.isArray(navigationData.items)) {
        navigationData.items.forEach(item => {
            const navElement = document.querySelector(item.selector);
            if (navElement) {
                navElement.textContent = item.text;
                navElement.href = item.href;
            }
        });
    }
}

/**
 * Update a specific section based on its configuration
 * @param {Object} sectionData - The section configuration data
 */
function updateSection(sectionData) {
    if (!sectionData || !sectionData.content) return;

    const content = sectionData.content;

    // Update hero section
    if (sectionData.id === 'hero') {
        updateHeroSection(content);
    }

    // Update about section
    else if (sectionData.id === 'about') {
        updateAboutSection(content);
    }

    // Update care guides section
    else if (sectionData.id === 'care-guides') {
        updateCareGuidesSection(content);
    }

    // Update tips section
    else if (sectionData.id === 'tips') {
        updateTipsSection(content);
    }

    // Update newsletter section
    else if (sectionData.id === 'newsletter') {
        updateNewsletterSection(content);
    }

    // Update testimonials section
    else if (sectionData.id === 'testimonials') {
        updateTestimonialsSection(content);
    }
}

/**
 * Update the hero section content
 * @param {Object} content - The hero section content data
 */
function updateHeroSection(content) {
    // Update heading
    const headingElement = document.querySelector('#hero-title');
    if (headingElement && content.heading) {
        // Preserve the styling for the word "life" by wrapping it in a span
        const headingText = content.heading.replace('life', '<span class="text-primary font-medium">life</span>');
        headingElement.innerHTML = headingText;
    }

    // Update subheading
    const subheadingElement = document.querySelector('#hero-description');
    if (subheadingElement && content.subheading) {
        subheadingElement.textContent = content.subheading;
    }

    // Update button text
    const buttonElement = document.querySelector('#hero-cta');
    if (buttonElement && content.buttonText) {
        buttonElement.textContent = content.buttonText;
    }

    // Update image
    const imageElement = document.querySelector('#hero-image');
    if (imageElement && content.image) {
        imageElement.src = content.image;
    }
}

/**
 * Update the about section content
 * @param {Object} content - The about section content data
 */
function updateAboutSection(content) {
    // Update heading
    const headingElement = document.querySelector('#about-title');
    if (headingElement && content.heading) {
        // Preserve the styling for the word "Verdant" by wrapping it in a span
        const headingText = content.heading.replace('Verdant', '<span class="text-primary font-medium">Verdant</span>');
        headingElement.innerHTML = headingText;
    }

    // Update paragraphs
    if (content.paragraphs && Array.isArray(content.paragraphs)) {
        // Find the paragraph elements
        const paragraphElements = [
            document.querySelector('#about-description-1'),
            document.querySelector('#about-description-2')
        ];

        // Update paragraphs that exist
        for (let i = 0; i < Math.min(paragraphElements.length, content.paragraphs.length); i++) {
            if (paragraphElements[i]) {
                paragraphElements[i].textContent = content.paragraphs[i];
            }
        }
    }

    // Update button text
    const buttonElement = document.querySelector('#about-cta');
    if (buttonElement && content.buttonText) {
        buttonElement.textContent = content.buttonText;
    }

    // Update image
    const imageElement = document.querySelector('#about-image');
    if (imageElement && content.image) {
        imageElement.src = content.image;
    }
}

/**
 * Update the care guides section content
 * @param {Object} content - The care guides section content data
 */
function updateCareGuidesSection(content) {
    // Update heading
    const headingElement = document.querySelector('#care-guides-title');
    if (headingElement && content.heading) {
        // Preserve the styling for "Care Guides" by wrapping it in a span
        const headingText = content.heading.replace('Care Guides', '<span class="text-primary font-medium">Care Guides</span>');
        headingElement.innerHTML = headingText;
    }

    // Update subheading
    const subheadingElement = document.querySelector('#care-guides-description');
    if (subheadingElement && content.subheading) {
        subheadingElement.textContent = content.subheading;
    }

    // Update guides
    if (content.guides && Array.isArray(content.guides)) {
        content.guides.forEach((guide, index) => {
            // Guide elements have IDs like guide-watering, guide-light, guide-soil
            const guideId = guide.selector || `#guide-${guide.title.toLowerCase().replace(/\s+/g, '-')}`;
            // Ensure special characters in CSS selectors are properly escaped
            // const escapedGuideId = guideId.replace(/([!"#$%&'()*+,./:;<=>?@[\]^`{|}~])/g, '\\$1');
            const escapedGuideId = guideId.replace('#', '');
            // console.log(guideId, escapedGuideId, guideId.includes('&'));
            const guideElement = guideId.includes('&') ? document.querySelector(`[id="${escapedGuideId}"]`) : document.querySelector(guideId);

            if (guideElement) {
                // Update title
                const titleElement = guideElement.querySelector(`${guideId}-title`);
                if (titleElement && guide.title) {
                    titleElement.textContent = guide.title;
                }

                // Update description
                const descriptionElement = guideElement.querySelector(`${guideId}-description`);
                if (descriptionElement && guide.description) {
                    descriptionElement.textContent = guide.description;
                }

                // Update image
                const imageElement = guideElement.querySelector(`${guideId}-image`);
                if (imageElement && guide.image) {
                    imageElement.src = guide.image;
                }
            }
        });
    }
}

/**
 * Update the tips section content
 * @param {Object} content - The tips section content data
 */
function updateTipsSection(content) {
    // Update heading
    const headingElement = document.querySelector('#tips-title');
    if (headingElement && content.heading) {
        // Preserve the styling for "Tips & Tricks" by wrapping it in a span
        const headingText = content.heading.replace('Tips & Tricks', '<span class="text-primary font-medium">Tips & Tricks</span>');
        headingElement.innerHTML = headingText;
    }

    // Update subheading
    const subheadingElement = document.querySelector('#tips-description');
    if (subheadingElement && content.subheading) {
        subheadingElement.textContent = content.subheading;
    }

    // Update tips
    if (content.tips && Array.isArray(content.tips)) {
        content.tips.forEach((tip, index) => {
            const tipId = tip.selector || `#tip-${index + 1}`;
            const tipElement = document.querySelector(tipId);

            if (tipElement) {
                // Update title
                const titleElement = tipElement.querySelector(`${tipId}-title`);
                if (titleElement && tip.title) {
                    titleElement.textContent = tip.title;
                }

                // Update description
                const descriptionElement = tipElement.querySelector(`${tipId}-description`);
                if (descriptionElement && tip.description) {
                    descriptionElement.textContent = tip.description;
                }
            }
        });
    }
}

/**
 * Update the newsletter section content
 * @param {Object} content - The newsletter section content data
 */
function updateNewsletterSection(content) {
    // Update heading
    const headingElement = document.querySelector('#newsletter-title');
    if (headingElement && content.heading) {
        headingElement.textContent = content.heading;
    }

    // Update description
    const descriptionElement = document.querySelector('#newsletter-description');
    if (descriptionElement && content.description) {
        descriptionElement.textContent = content.description;
    }

    // Update button text
    const buttonElement = document.querySelector('#newsletter-submit');
    if (buttonElement && content.buttonText) {
        buttonElement.textContent = content.buttonText;
    }

    // Update input placeholder
    const inputElement = document.querySelector('#newsletter-email');
    if (inputElement && content.inputPlaceholder) {
        inputElement.placeholder = content.inputPlaceholder;
    }
}

/**
 * Update the testimonials section content
 * @param {Object} content - The testimonials section content data
 */
function updateTestimonialsSection(content) {
    // Update heading
    const headingElement = document.querySelector('#testimonials-title');
    if (headingElement && content.heading) {
        // Preserve the styling for "Community Says" by wrapping it in a span
        const headingText = content.heading.replace('Community Says', '<span class="text-primary font-medium">Community Says</span>');
        headingElement.innerHTML = headingText;
    }

    // Update subheading
    const subheadingElement = document.querySelector('#testimonials-description');
    if (subheadingElement && content.subheading) {
        subheadingElement.textContent = content.subheading;
    }

    // Update testimonials
    if (content.testimonials && Array.isArray(content.testimonials)) {
        content.testimonials.forEach((testimonial, index) => {
            const testimonialId = testimonial.selector || `#testimonial-${index + 1}`;
            const testimonialElement = document.querySelector(testimonialId);

            if (testimonialElement) {
                // Update name
                const nameElement = testimonialElement.querySelector(`${testimonialId}-name`);
                if (nameElement && testimonial.name) {
                    nameElement.textContent = testimonial.name;
                }

                // Update role/title
                const roleElement = testimonialElement.querySelector(`${testimonialId}-title`);
                if (roleElement && testimonial.role) {
                    roleElement.textContent = testimonial.role;
                }

                // Update quote/text
                const textElement = testimonialElement.querySelector(`${testimonialId}-text`);
                if (textElement && testimonial.quote) {
                    textElement.textContent = testimonial.quote;
                }

                // Update image
                const imageElement = testimonialElement.querySelector(`${testimonialId}-image`);
                if (imageElement && testimonial.image) {
                    imageElement.src = testimonial.image;
                    // Update alt text to include person's name
                    if (testimonial.name) {
                        imageElement.alt = testimonial.name;
                    }
                }
            }
        });
    }
}
