document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('customization-form');
  // Store the current site data globally
  let currentSiteData = {};
  // Store the initial raw JSON value for comparison
  let initialRawJsonValue = '';

  // Initialize image preview functionality
  initImagePreview();

  refreshPreview();

  // Load existing site data
  fetch('config/site.json')
    .then((response) => response.json())
    .then((data) => {
      currentSiteData = data;
      populateForm(data);

      // Populate the raw JSON editor and store initial value
      const jsonString = JSON.stringify(data, null, 2);
      document.getElementById('raw-json-editor').value = jsonString;
      initialRawJsonValue = jsonString;
    })
    .catch((error) => {
      console.error('Error loading section data:', error);
      // Use default data if fetch fails
      const defaultData = getDefaultData();
      currentSiteData = defaultData;
      populateForm(defaultData);

      // Populate the raw JSON editor with default data and store initial value
      const jsonString = JSON.stringify(defaultData, null, 2);
      document.getElementById('raw-json-editor').value = jsonString;
      initialRawJsonValue = jsonString;
    });

  // Populate form with data
  function populateForm(data) {
    // Check if data is in the expected structure
    const sections = data.sections || [];

    // Populate navigation (if exists)
    if (data.navigation) {
      document.getElementById('nav-brand').value = data.navigation.brand || '';
      populateNavItems(data.navigation.items || []);
    }

    // Find each section by id and populate corresponding form fields
    const heroSection = sections.find(section => section.id === 'hero');
    if (heroSection && heroSection.content) {
      document.getElementById('hero-heading').value = heroSection.content.heading || '';
      document.getElementById('hero-subheading').value = heroSection.content.subheading || '';
      document.getElementById('hero-button-text').value = heroSection.content.buttonText || '';
      document.getElementById('hero-image').value = heroSection.content.image || '';
    }

    const aboutSection = sections.find(section => section.id === 'about');
    if (aboutSection && aboutSection.content) {
      document.getElementById('about-heading').value = aboutSection.content.heading || '';

      // Handle the about content in the textarea
      if (aboutSection.content.paragraphs && Array.isArray(aboutSection.content.paragraphs)) {
        // Join paragraphs with newlines for the textarea
        document.getElementById('about-content').value = aboutSection.content.paragraphs.join('\n\n');
      } else if (aboutSection.content.content) {
        document.getElementById('about-content').value = aboutSection.content.content;
      }

      document.getElementById('about-button-text').value = aboutSection.content.buttonText || '';
      document.getElementById('about-image').value = aboutSection.content.image || '';
    }

    const guidesSection = sections.find(section => section.id === 'care-guides');
    if (guidesSection && guidesSection.content) {
      document.getElementById('guides-heading').value = guidesSection.content.heading || '';
      document.getElementById('guides-subheading').value = guidesSection.content.subheading || '';

      // Populate guides list
      if (guidesSection.content.guides && Array.isArray(guidesSection.content.guides)) {
        populateGuides(guidesSection.content.guides);
      }
    }

    const tipsSection = sections.find(section => section.id === 'tips');
    if (tipsSection && tipsSection.content) {
      document.getElementById('tips-heading').value = tipsSection.content.heading || '';
      document.getElementById('tips-subheading').value = tipsSection.content.subheading || '';

      // Populate tips list
      if (tipsSection.content.tips && Array.isArray(tipsSection.content.tips)) {
        populateTips(tipsSection.content.tips);
      }
    }

    const newsletterSection = sections.find(section => section.id === 'newsletter');
    if (newsletterSection && newsletterSection.content) {
      document.getElementById('newsletter-heading').value = newsletterSection.content.heading || '';
      document.getElementById('newsletter-description').value = newsletterSection.content.description || '';
      document.getElementById('newsletter-button-text').value = newsletterSection.content.buttonText || '';
      document.getElementById('newsletter-placeholder').value = newsletterSection.content.inputPlaceholder || '';
    }

    const testimonialsSection = sections.find(section => section.id === 'testimonials');
    if (testimonialsSection && testimonialsSection.content) {
      document.getElementById('testimonials-heading').value = testimonialsSection.content.heading || '';
      document.getElementById('testimonials-subheading').value = testimonialsSection.content.subheading || '';

      // Populate testimonials list
      if (testimonialsSection.content.testimonials && Array.isArray(testimonialsSection.content.testimonials)) {
        populateTestimonials(testimonialsSection.content.testimonials);
      }
    }

    // Populate section selector with navigation too
    populateSectionSelector([{id: 'navigation', title: 'Navigation Menu'}, ...sections]);
  }

  // Populate the section selector dropdown
  function populateSectionSelector(sections) {
    const sectionSelector = document.getElementById('section-selector');
    sectionSelector.innerHTML = ''; // Clear existing options

    // Add options for each section
    sections.forEach(section => {
      const option = document.createElement('option');
      option.value = section.id;
      option.textContent = section.title;
      sectionSelector.appendChild(option);
    });

    // Trigger change event to show the first section
    sectionSelector.dispatchEvent(new Event('change'));
  }

  // Populate navigation items
  function populateNavItems(items) {
    const navItemsList = document.getElementById('nav-items-list');
    // Clear existing items except the template
    Array.from(navItemsList.children).forEach(child => {
      if (!child.matches('template')) {
        child.remove();
      }
    });

    // Add each navigation item
    items.forEach(item => {
      addNavItem(item.text, item.href, item.id);
    });

    // Initialize event listeners for the nav items
    initNavItemEventListeners();
  }

  // Populate testimonials
  function populateTestimonials(testimonials) {
    const testimonialsList = document.getElementById('testimonials-list');
    // Clear existing testimonials except the template
    Array.from(testimonialsList.children).forEach(child => {
      if (!child.matches('template')) {
        child.remove();
      }
    });

    // Add each testimonial
    testimonials.forEach(testimonial => {
      addTestimonial(testimonial);
    });

    // Initialize event listeners for testimonials
    initTestimonialEventListeners();
  }

  // Populate guides
  function populateGuides(guides) {
    const guidesList = document.getElementById('guides-list');
    // Clear existing guides except the template
    Array.from(guidesList.children).forEach(child => {
      if (!child.matches('template')) {
        child.remove();
      }
    });

    // Add each guide
    guides.forEach(guide => {
      addGuide(guide);
    });

    // Initialize event listeners for guides
    initGuideEventListeners();
  }

  // Populate tips
  function populateTips(tips) {
    const tipsList = document.getElementById('tips-list');
    // Clear existing tips except the template
    Array.from(tipsList.children).forEach(child => {
      if (!child.matches('template')) {
        child.remove();
      }
    });

    // Add each tip
    tips.forEach(tip => {
      addTip(tip);
    });

    // Initialize event listeners for tips
    initTipEventListeners();
  }

  // Add a new navigation item
  function addNavItem(text = '', href = '', id = '') {
    const navItemsList = document.getElementById('nav-items-list');
    const template = document.getElementById('nav-item-template');
    const clone = document.importNode(template.content, true);

    // Set values if provided
    if (text) clone.querySelector('.nav-item-text').value = text;
    if (href) clone.querySelector('.nav-item-href').value = href;
    if (id) clone.querySelector('.nav-item-id').value = id;

    // Generate a new ID if none provided
    if (!id) {
      clone.querySelector('.nav-item-id').value = 'nav-' + Date.now();
    }

    navItemsList.appendChild(clone);
    return clone;
  }

  // Add a new testimonial
  function addTestimonial(testimonial = {}) {
    const testimonialsList = document.getElementById('testimonials-list');
    const template = document.getElementById('testimonial-template');
    const clone = document.importNode(template.content, true);

    // Set values if provided
    if (testimonial.name) clone.querySelector('.testimonial-name').value = testimonial.name;
    if (testimonial.role) clone.querySelector('.testimonial-role').value = testimonial.role;
    if (testimonial.quote) clone.querySelector('.testimonial-quote').value = testimonial.quote;
    if (testimonial.image) clone.querySelector('.testimonial-image').value = testimonial.image;

    testimonialsList.appendChild(clone);

    // Set up the image preview if image URL is provided
    if (testimonial.image) {
      const addedTestimonialItem = testimonialsList.lastElementChild;
      const previewContainer = addedTestimonialItem.querySelector('.testimonial-image-preview');

      if (previewContainer) {
        previewImage(testimonial.image, previewContainer);
      }
    }

    return clone;
  }

  // Add a new guide
  function addGuide(guide = {}) {
    const guidesList = document.getElementById('guides-list');
    const template = document.getElementById('guide-template');
    const clone = document.importNode(template.content, true);

    // Set values if provided
    if (guide.title) clone.querySelector('.guide-title').value = guide.title;
    if (guide.description) clone.querySelector('.guide-description').value = guide.description;
    if (guide.image) clone.querySelector('.guide-image').value = guide.image;
    if (guide.selector) clone.querySelector('.guide-selector').value = guide.selector;

    guidesList.appendChild(clone);

    // Set up the image preview if image URL is provided
    if (guide.image) {
      const addedGuideItem = guidesList.lastElementChild;
      const previewContainer = addedGuideItem.querySelector('.guide-image-preview');

      if (previewContainer) {
        previewImage(guide.image, previewContainer);
      }
    }

    return clone;
  }

  // Add a new tip
  function addTip(tip = {}) {
    const tipsList = document.getElementById('tips-list');
    const template = document.getElementById('tip-template');
    const clone = document.importNode(template.content, true);

    // Set values if provided
    if (tip.title) clone.querySelector('.tip-title').value = tip.title;
    if (tip.description) clone.querySelector('.tip-description').value = tip.description;

    tipsList.appendChild(clone);
    return clone;
  }

  // Initialize event listeners for navigation items
  function initNavItemEventListeners() {
    // Remove navigation item
    document.querySelectorAll('.remove-nav-item').forEach(button => {
      if (!button.hasEventListener) {
        button.hasEventListener = true;
        button.addEventListener('click', function() {
          this.closest('.nav-item').remove();
        });
      }
    });
  }

  // Initialize event listeners for testimonials
  function initTestimonialEventListeners() {
    // Remove testimonial
    document.querySelectorAll('.remove-testimonial').forEach(button => {
      if (!button.hasEventListener) {
        button.hasEventListener = true;
        button.addEventListener('click', function() {
          this.closest('.testimonial-item').remove();
        });
      }
    });

    // Initialize image previews for testimonial items
    document.querySelectorAll('.testimonial-item:not(template .testimonial-item)').forEach(testimonialItem => {
      const imageInput = testimonialItem.querySelector('.testimonial-image');
      const previewContainer = testimonialItem.querySelector('.testimonial-image-preview');

      // Show preview on load if there's a value
      if (imageInput && previewContainer && imageInput.value.trim()) {
        previewImage(imageInput.value, previewContainer);
      }

      // Add event listener for input changes
      if (imageInput && previewContainer) {
        if (!imageInput.hasChangeListener) {
          imageInput.hasChangeListener = true;
          imageInput.addEventListener('input', function() {
            previewImage(this.value, previewContainer);
          });
        }
      }
    });
  }

  // Initialize event listeners for guides
  function initGuideEventListeners() {
    // Remove guide
    document.querySelectorAll('.remove-guide').forEach(button => {
      if (!button.hasEventListener) {
        button.hasEventListener = true;
        button.addEventListener('click', function() {
          this.closest('.guide-item').remove();
        });
      }
    });

    // Initialize image previews for guide items
    document.querySelectorAll('.guide-item:not(template .guide-item)').forEach(guideItem => {
      const imageInput = guideItem.querySelector('.guide-image');
      const previewContainer = guideItem.querySelector('.guide-image-preview');

      // Show preview on load if there's a value
      if (imageInput && previewContainer && imageInput.value.trim()) {
        previewImage(imageInput.value, previewContainer);
      }

      // Add event listener for input changes
      if (imageInput && previewContainer) {
        if (!imageInput.hasChangeListener) {
          imageInput.hasChangeListener = true;
          imageInput.addEventListener('input', function() {
            previewImage(this.value, previewContainer);
          });
        }
      }
    });
  }

  // Initialize event listeners for tips
  function initTipEventListeners() {
    // Remove tip
    document.querySelectorAll('.remove-tip').forEach(button => {
      if (!button.hasEventListener) {
        button.hasEventListener = true;
        button.addEventListener('click', function() {
          this.closest('.tip-item').remove();
        });
      }
    });
  }

  // Helper function to create image previews
  function previewImage(imageUrl, previewContainer) {
    if (!previewContainer) return;
    // console.log('Previewing image:', imageUrl);

    if (imageUrl && imageUrl.trim()) {
      // Clear the container
      previewContainer.innerHTML = '';

      // Create image element
      const img = document.createElement('img');
      img.src = imageUrl.trim();
      img.className = 'w-full h-full object-cover';
      img.onerror = function() {
        previewContainer.innerHTML = '<span class="text-red-500">Invalid image URL</span>';
      };

      previewContainer.appendChild(img);
      return true;
    } else {
      previewContainer.innerHTML = '<span class="text-gray-400">Image preview will appear here</span>';
      return false;
    }
  }

  // Initialize image preview functionality
  function initImagePreview() {
    // For all preview image buttons (fixed elements)
    document.querySelectorAll('.preview-image-btn').forEach(button => {
      const targetId = button.dataset.target;
      const inputField = button.closest('div').querySelector('input');

      // Add input listener for real-time updates
      if (inputField) {
        inputField.addEventListener('input', function() {
          previewImage(this.value, document.getElementById(targetId));
        });
      }

      // Show preview on button click
      button.addEventListener('click', function() {
        const inputField = this.closest('div').querySelector('input');
        if (inputField) {
          previewImage(inputField.value, document.getElementById(targetId));
        }
      });

      // Show preview on page load if there's a value
      if (inputField && inputField.value.trim()) {
        previewImage(inputField.value, document.getElementById(targetId));
      }
    });
  }

  // Default data for initial display
  function getDefaultData() {
    return {
      "sections": [
        {
          "id": "hero",
          "title": "Hero Section",
          "content": {
            "heading": "Bring life to your space with plants",
            "subheading": "Learn how to care for your indoor plants with our expert guides and simple tips.",
            "buttonText": "Get Started",
            "image": "https://images.unsplash.com/photo-1463320898484-cdee8141c787?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
          }
        },
        {
          "id": "about",
          "title": "About Section",
          "content": {
            "heading": "About Verdant",
            "paragraphs": [
              "We believe that everyone deserves to enjoy the beauty and benefits of plants, regardless of experience level.",
              "Our mission is to make plant care accessible, enjoyable, and rewarding."
            ],
            "buttonText": "Learn More",
            "image": "https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
          }
        },
        {
          "id": "care-guides",
          "title": "Care Guides Section",
          "content": {
            "heading": "Essential Care Guides",
            "subheading": "Everything you need to know to keep your plants thriving",
            "guides": []
          }
        },
        {
          "id": "newsletter",
          "title": "Newsletter Section",
          "content": {
            "heading": "Join Our Plant Community",
            "description": "Sign up for our newsletter to receive seasonal care tips, exclusive guides, and plant inspiration.",
            "buttonText": "Subscribe",
            "inputPlaceholder": "Your email address"
          }
        },
        {
          "id": "testimonials",
          "title": "Testimonials Section",
          "content": {
            "heading": "What Our Community Says",
            "subheading": "Hear from plant lovers who've transformed their spaces",
            "testimonials": []
          }
        }
      ]
    };
  }

  // Handle form submission
  form.addEventListener('submit', async function (event) {
    event.preventDefault();

    // Check if the raw JSON editor has been changed compared to the initial value
    const rawJsonEditor = document.getElementById('raw-json-editor');
    if (rawJsonEditor.value && rawJsonEditor.value !== initialRawJsonValue) {
      try {
        // Parse and validate the JSON
        const updatedData = JSON.parse(rawJsonEditor.value);
        saveData(updatedData);
        return;
      } catch (error) {
        console.error('Invalid JSON:', error);
        showStatusMessage('Invalid JSON format. Please check your syntax.', 'error');
        return;
      }
    }

    // Otherwise, collect data from the form fields
    // Get the current site data structure
    let currentData = JSON.parse(JSON.stringify(currentSiteData)); // Deep clone to avoid reference issues
    if (!currentData.sections) currentData.sections = [];

    // Ensure navigation exists
    if (!currentData.navigation) currentData.navigation = { items: [] };

    // Update navigation
    currentData.navigation.brand = document.getElementById('nav-brand').value;
    currentData.navigation.items = collectNavItems();

    // Update the data with form values
    const sections = currentData.sections || [];

    // Update Hero section
    const heroIndex = sections.findIndex(section => section.id === 'hero');
    if (heroIndex >= 0) {
      sections[heroIndex].content.heading = document.getElementById('hero-heading').value;
      sections[heroIndex].content.subheading = document.getElementById('hero-subheading').value;
      sections[heroIndex].content.buttonText = document.getElementById('hero-button-text').value;
      sections[heroIndex].content.image = document.getElementById('hero-image').value;
    }

    // Update About section
    const aboutIndex = sections.findIndex(section => section.id === 'about');
    if (aboutIndex >= 0) {
      sections[aboutIndex].content.heading = document.getElementById('about-heading').value;
      sections[aboutIndex].content.paragraphs = document.getElementById('about-content').value.split('\n\n').filter(p => p.trim());
      sections[aboutIndex].content.buttonText = document.getElementById('about-button-text').value;
      sections[aboutIndex].content.image = document.getElementById('about-image').value;
    }

    // Update Guides section
    const guidesIndex = sections.findIndex(section => section.id === 'care-guides');
    if (guidesIndex >= 0) {
      sections[guidesIndex].content.heading = document.getElementById('guides-heading').value;
      sections[guidesIndex].content.subheading = document.getElementById('guides-subheading').value;
      sections[guidesIndex].content.guides = collectGuides();
    }

    // Update Tips section
    const tipsIndex = sections.findIndex(section => section.id === 'tips');
    if (tipsIndex >= 0) {
      sections[tipsIndex].content.heading = document.getElementById('tips-heading').value;
      sections[tipsIndex].content.subheading = document.getElementById('tips-subheading').value;
      sections[tipsIndex].content.tips = collectTips();
    }

    // Update Newsletter section
    const newsletterIndex = sections.findIndex(section => section.id === 'newsletter');
    if (newsletterIndex >= 0) {
      sections[newsletterIndex].content.heading = document.getElementById('newsletter-heading').value;
      sections[newsletterIndex].content.description = document.getElementById('newsletter-description').value;
      sections[newsletterIndex].content.buttonText = document.getElementById('newsletter-button-text').value;
      sections[newsletterIndex].content.inputPlaceholder = document.getElementById('newsletter-placeholder').value;
    }

    // Update Testimonials section
    const testimonialsIndex = sections.findIndex(section => section.id === 'testimonials');
    if (testimonialsIndex >= 0) {
      sections[testimonialsIndex].content.heading = document.getElementById('testimonials-heading').value;
      sections[testimonialsIndex].content.subheading = document.getElementById('testimonials-subheading').value;
      sections[testimonialsIndex].content.testimonials = collectTestimonials();
    }

    // Update the current site data and save
    currentData.sections = sections;
    saveData(currentData);
  });

  // Collect all navigation items
  function collectNavItems() {
    const items = [];
    document.querySelectorAll('.nav-item:not(template .nav-item)').forEach(item => {
      const text = item.querySelector('.nav-item-text').value;
      const href = item.querySelector('.nav-item-href').value;
      const id = item.querySelector('.nav-item-id').value;

      if (text && href) {
        items.push({
          id: id || `nav-${Date.now()}`,
          text,
          href,
          selector: `#${id || `nav-${Date.now()}`}`
        });
      }
    });
    return items;
  }

  // Collect all testimonial data
  function collectTestimonials() {
    const testimonials = [];
    document.querySelectorAll('.testimonial-item:not(template .testimonial-item)').forEach((item, index) => {
      const name = item.querySelector('.testimonial-name').value;
      const role = item.querySelector('.testimonial-role').value;
      const quote = item.querySelector('.testimonial-quote').value;
      const image = item.querySelector('.testimonial-image').value;

      if (name && quote) {
        testimonials.push({
          name,
          role,
          quote,
          image,
          selector: `#testimonial-${index + 1}`
        });
      }
    });
    return testimonials;
  }

  // Collect all guide data
  function collectGuides() {
    const guides = [];
    document.querySelectorAll('.guide-item:not(template .guide-item)').forEach((item, index) => {
      const title = item.querySelector('.guide-title').value;
      const description = item.querySelector('.guide-description').value;
      const image = item.querySelector('.guide-image').value;

      if (title && description) {
        guides.push({
          title,
          description,
          image,
          // selector: `#guide-${title.toLowerCase().replace(/\s+/g, '-')}`
          selector: item.querySelector('.guide-selector').value
        });
      }
    });
    return guides;
  }

  // Collect all tip data
  function collectTips() {
    const tips = [];
    document.querySelectorAll('.tip-item:not(template .tip-item)').forEach((item, index) => {
      const title = item.querySelector('.tip-title').value;
      const description = item.querySelector('.tip-description').value;

      if (title && description) {
        tips.push({
          title,
          description,
          selector: `#tip-${index + 1}`
        });
      }
    });
    return tips;
  }

  // Show status message
  function showStatusMessage(message, type = 'success') {
    const statusMessage = document.getElementById('status-message');
    statusMessage.textContent = message;
    statusMessage.classList.remove('hidden', 'bg-green-100', 'text-green-800', 'bg-red-100', 'text-red-800');

    if (type === 'error') {
      statusMessage.classList.add('bg-red-100', 'text-red-800');
    } else {
      statusMessage.classList.add('bg-green-100', 'text-green-800');
    }

    // Hide the message after 3 seconds
    setTimeout(() => {
      statusMessage.classList.add('hidden');
    }, 3000);
  }

  // Save data to site.json
  function saveData(data) {
    console.log('Saving data:', data);

    // Update the global data reference
    currentSiteData = data;

    // Update the raw JSON editor and the initial value for future comparisons
    const jsonString = JSON.stringify(data, null, 2);
    document.getElementById('raw-json-editor').value = jsonString;
    initialRawJsonValue = jsonString;

    // Send data to the server
    fetch('save-config.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        file: 'config/site.json',
        data: data
      })
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(result => {
      console.log('Success:', result);
      showStatusMessage('Changes saved successfully!');

      // Refresh the preview iframe
      refreshPreview();
    })
    .catch(error => {
      console.error('Error:', error);
      showStatusMessage('Error saving changes. See console for details.', 'error');
    });
  }

  // Function to refresh the iframe with no cache
  function refreshPreview() {
    const iframe = document.getElementById('preview-iframe');
    const currentSrc = iframe.src.split('?')[0]; // Remove any existing query parameters
    iframe.src = currentSrc + '?t=' + new Date().getTime(); // Add timestamp as query parameter
  }

  document.querySelector('.refresh-preview-btn').addEventListener('click', function() {
    refreshPreview();
  });

  // Download the JSON configuration
  document.getElementById('download-json-btn').addEventListener('click', function() {
    // Get the current data
    let dataToDownload;

    try {
      // First try to use the raw JSON editor content
      const rawJsonEditor = document.getElementById('raw-json-editor');
      dataToDownload = JSON.parse(rawJsonEditor.value);
    } catch (error) {
      // Fall back to the current site data
      dataToDownload = currentSiteData;
    }

    // Create a download link
    const dataStr = JSON.stringify(dataToDownload, null, 2);
    const blob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(blob);

    const downloadLink = document.createElement('a');
    downloadLink.href = url;
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0]; // Format: YYYY-MM-DD
    downloadLink.download = `site-config-${formattedDate}.json`;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
    URL.revokeObjectURL(url);
  });

  // Section selector functionality
  const sectionSelector = document.getElementById('section-selector');
  const sectionForms = document.querySelectorAll('.section-form');

  sectionSelector.addEventListener('change', function () {
    const selectedSection = this.value;

    // Hide all section forms
    sectionForms.forEach((form) => {
      form.classList.add('hidden');
    });

    // Show selected section form
    const selectedForm = document.getElementById(`${selectedSection}-section-form`);
    selectedForm.classList.remove('hidden');

    // Refresh image previews in the selected section
    const refreshImagePreviews = () => {
      // Refresh fixed image previews (hero, about, etc.)
      selectedForm.querySelectorAll('.preview-image-btn').forEach(button => {
        const targetId = button.dataset.target;
        const inputField = button.closest('div').querySelector('input');
        if (inputField && inputField.value.trim() && document.getElementById(targetId)) {
          previewImage(inputField.value, document.getElementById(targetId));
        }
      });

      // Refresh guide image previews
      selectedForm.querySelectorAll('.guide-item:not(template .guide-item)').forEach(guideItem => {
        const imageInput = guideItem.querySelector('.guide-image');
        const previewContainer = guideItem.querySelector('.guide-image-preview');
        if (imageInput && previewContainer && imageInput.value.trim()) {
          previewImage(imageInput.value, previewContainer);
        }
      });

      // Refresh testimonial image previews
      selectedForm.querySelectorAll('.testimonial-item:not(template .testimonial-item)').forEach(testimonialItem => {
        const imageInput = testimonialItem.querySelector('.testimonial-image');
        const previewContainer = testimonialItem.querySelector('.testimonial-image-preview');
        if (imageInput && previewContainer && imageInput.value.trim()) {
          previewImage(imageInput.value, previewContainer);
        }
      });
    };

    // Use setTimeout to ensure the DOM is fully updated before refreshing previews
    setTimeout(refreshImagePreviews, 0);
  });

  // Layout toggle functionality
  const defaultViewBtn = document.getElementById('default-view');
  const editorViewBtn = document.getElementById('editor-view');
  const previewViewBtn = document.getElementById('preview-view');

  const formSection = document.getElementById('form-section');
  const previewSectionContainer = document.getElementById('preview-section-container');
  const layoutContainer = document.getElementById('layout-container');

  // Function to set active button styles
  function setActiveButton(activeBtn) {
    // Reset all buttons
    [defaultViewBtn, editorViewBtn, previewViewBtn].forEach((btn) => {
      btn.classList.remove('bg-primary', 'text-white');
      btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
    });

    // Set active button
    activeBtn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100');
    activeBtn.classList.add('bg-primary', 'text-white');
  }

  // Default view (both panels)
  defaultViewBtn.addEventListener('click', function () {
    formSection.classList.remove('lg:w-full', 'hidden');
    previewSectionContainer.classList.remove('lg:w-full', 'hidden');
    formSection.classList.add('lg:w-1/2');
    previewSectionContainer.classList.add('lg:w-1/2');
    layoutContainer.classList.add('lg:flex-row');
    setActiveButton(defaultViewBtn);
  });

  // Editor-only view
  editorViewBtn.addEventListener('click', function () {
    formSection.classList.remove('lg:w-1/2', 'hidden');
    formSection.classList.add('lg:w-full');
    previewSectionContainer.classList.add('hidden');
    previewSectionContainer.classList.remove('lg:w-1/2', 'lg:w-full');
    layoutContainer.classList.remove('lg:flex-row');
    setActiveButton(editorViewBtn);
  });

  // Preview-only view
  previewViewBtn.addEventListener('click', function () {
    previewSectionContainer.classList.remove('lg:w-1/2', 'hidden');
    previewSectionContainer.classList.add('lg:w-full');
    formSection.classList.add('hidden');
    formSection.classList.remove('lg:w-1/2', 'lg:w-full');
    layoutContainer.classList.remove('lg:flex-row');
    setActiveButton(previewViewBtn);
  });

  // Add event listeners for "Add" buttons

  // Add navigation item button
  document.getElementById('add-nav-item-btn').addEventListener('click', function() {
    const newNavItem = addNavItem();
    initNavItemEventListeners();
  });

  // Add testimonial button
  document.getElementById('add-testimonial-btn').addEventListener('click', function() {
    const newTestimonial = addTestimonial();
    initTestimonialEventListeners();

    // Add input event listener to the newly added testimonial's image input
    const testimonialItem = document.getElementById('testimonials-list').lastElementChild;
    if (testimonialItem) {
      const imageInput = testimonialItem.querySelector('.testimonial-image');
      const imagePreview = testimonialItem.querySelector('.testimonial-image-preview');
      if (imageInput && imagePreview) {
        imageInput.addEventListener('input', function() {
          previewImage(this.value, imagePreview);
        });
      }
    }
  });

  // Add guide button
  document.getElementById('add-guide-btn').addEventListener('click', function() {
    const newGuide = addGuide();
    initGuideEventListeners();

    // Add input event listener to the newly added guide's image input
    const guideItem = document.getElementById('guides-list').lastElementChild;
    if (guideItem) {
      const imageInput = guideItem.querySelector('.guide-image');
      const imagePreview = guideItem.querySelector('.guide-image-preview');
      if (imageInput && imagePreview) {
        imageInput.addEventListener('input', function() {
          previewImage(this.value, imagePreview);
        });
      }
    }
  });

  // Add tip button
  document.getElementById('add-tip-btn').addEventListener('click', function() {
    const newTip = addTip();
    initTipEventListeners();
  });
});
