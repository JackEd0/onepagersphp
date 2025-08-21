s3xtans: update admin.js to use correct elements names and ids

GitHub Copilot: # JavaScript ID Mismatches in admin.js

Looking at your code, I found inconsistencies between the element IDs in your HTML and the IDs being referenced in your JavaScript. Here's an update to the admin.js file to correctly match the HTML element IDs:

```javascript
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('customization-form');

  // Load existing section data
  fetch('config/sections.json')
    .then((response) => response.json())
    .then((data) => {
      populateForm(data);
    })
    .catch((error) => {
      console.error('Error loading section data:', error);
      // Use default data if fetch fails
      const defaultData = getDefaultData();
      populateForm(defaultData);
    });

  // Populate form with data
  function populateForm(data) {
    if (data.hero) {
      document.getElementById('hero-heading').value = data.hero.title || '';
      document.getElementById('hero-subheading').value = data.hero.description || '';
      document.getElementById('hero-button-text').value = data.hero.buttonText || '';
      document.getElementById('hero-image').value = data.hero.imageUrl || '';
    }

    if (data.about) {
      document.getElementById('about-heading').value = data.about.title || '';
      // Handle about content differently since it uses paragraphs in HTML
      // You might need to adapt this based on your exact implementation
      document.getElementById('about-button-text').value = data.about.buttonText || '';
      document.getElementById('about-image').value = data.about.imageUrl || '';
    }

    if (data.guides) {
      document.getElementById('guides-heading').value = data.guides.title || '';
      document.getElementById('guides-subheading').value = data.guides.description || '';
    }

    // Initialize preview with the same data
    updatePreview();
  }

  // Default data for initial display
  function getDefaultData() {
    return {
      hero: {
        title: 'Bring life to your space with plants',
        description: 'Learn how to care for your indoor plants with our expert guides and simple tips.',
        buttonText: 'Get Started',
        imageUrl:
          'https://images.unsplash.com/photo-1463320898484-cdee8141c787?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
      },
      about: {
        title: 'About Verdant',
        content:
          'We believe that everyone deserves to enjoy the beauty and benefits of plants, regardless of experience level. Our mission is to make plant care accessible, enjoyable, and rewarding.',
        buttonText: 'Learn More',
        imageUrl:
          'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
      },
      guides: {
        title: 'Essential Care Guides',
        description: 'Everything you need to know to keep your plants thriving',
      },
    };
  }

  // Update preview based on current form values
  function updatePreview() {
    // Update Hero section
    const heroHeading = document.getElementById('hero-heading').value;
    const heroSubheading = document.getElementById('hero-subheading').value;
    const heroImage = document.getElementById('hero-image').value;

    document.getElementById('preview-hero-title').innerHTML = heroHeading
      ? formatTitle(heroHeading)
      : 'Bring <span class="text-primary font-medium">life</span> to your space with plants';
    document.getElementById('preview-hero-description').textContent =
      heroSubheading || 'Learn how to care for your indoor plants with our expert guides and simple tips.';

    if (heroImage) {
      document.getElementById('preview-hero-image').src = heroImage;
    }

    // Update About section
    const aboutHeading = document.getElementById('about-heading').value;
    // Handle content differently based on your implementation
    // For example, you might need to collect content from multiple paragraph inputs
    const aboutContent = ""; // Implement based on your paragraph handling
    const aboutImage = document.getElementById('about-image').value;

    document.getElementById('preview-about-title').innerHTML = aboutHeading
      ? formatTitle(aboutHeading)
      : 'About <span class="text-primary font-medium">Verdant</span>';
    document.getElementById('preview-about-content').textContent =
      aboutContent ||
      'We believe that everyone deserves to enjoy the beauty and benefits of plants, regardless of experience level. Our mission is to make plant care accessible, enjoyable, and rewarding.';

    if (aboutImage) {
      document.getElementById('preview-about-image').src = aboutImage;
    }

    // Update Guides section
    const guidesHeading = document.getElementById('guides-heading').value;
    const guidesSubheading = document.getElementById('guides-subheading').value;

    document.getElementById('preview-guides-title').innerHTML = guidesHeading
      ? formatTitle(guidesHeading)
      : 'Essential <span class="text-primary font-medium">Care Guides</span>';
    document.getElementById('preview-guides-description').textContent =
      guidesSubheading || 'Everything you need to know to keep your plants thriving';
  }

  // Helper to format titles with highlighting
  function formatTitle(title) {
    // Look for words to highlight between * characters, like *word*
    return title.replace(/\*(.*?)\*/g, '<span class="text-primary font-medium">$1</span>');
  }

  // Add real-time preview for all form fields
  const formInputs = form.querySelectorAll('input, textarea');
  formInputs.forEach((input) => {
    input.addEventListener('input', updatePreview);
  });

  // Handle form submission
  form.addEventListener('submit', function (event) {
    event.preventDefault();

    // Create data object from form values
    const formData = {
      hero: {
        title: document.getElementById('hero-heading').value,
        description: document.getElementById('hero-subheading').value,
        buttonText: document.getElementById('hero-button-text').value,
        imageUrl: document.getElementById('hero-image').value,
      },
      about: {
        title: document.getElementById('about-heading').value,
        // Handle content collection based on your implementation
        buttonText: document.getElementById('about-button-text').value,
        imageUrl: document.getElementById('about-image').value,
      },
      guides: {
        title: document.getElementById('guides-heading').value,
        description: document.getElementById('guides-subheading').value,
      },
    };

    // Display save confirmation
    saveData(formData);
  });

  // Rest of the code remains the same...
  // ...
}
```

## Key Changes Made

1. Updated field references to match HTML IDs:
   - Changed `hero-title` to `hero-heading`
   - Changed `hero-description` to `hero-subheading`
   - Added `hero-button-text`
   - Changed `about-title` to `about-heading`
   - Added `about-button-text`
   - Changed `guides-title` to `guides-heading`
   - Changed `guides-description` to `guides-subheading`

2. Modified the `updatePreview()` function to use the correct IDs when retrieving form values

3. Updated the `formData` object in the submit event handler to use the correct field IDs

Note: The code assumes that the preview elements (like `preview-hero-title`) exist in your HTML. You may need to further adjust the implementation for the about content section, depending on how you're handling paragraphs in your application.

s3xtans: remove the button to add paragraph, it will be a textarea with some wysiwyg editor

GitHub Copilot: # Replace Paragraph List with WYSIWYG Textarea

I'll replace the paragraph list and "Add Paragraph" button with a textarea that can be enhanced with a WYSIWYG editor:

```html
<div id="about-paragraphs-container" class="mb-4">
    <label for="about-content" class="block text-sm font-medium mb-1 text-gray-700">Content:</label>
    <textarea id="about-content" name="about-content" placeholder="Enter about section content" rows="6"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
    <p class="mt-1 text-sm text-gray-500">This editor supports basic formatting. You can later integrate a WYSIWYG editor like TinyMCE or CKEditor.</p>
</div>
```

Now let's update the JavaScript to handle this textarea instead of the paragraph list:

```javascript
// Inside the populateForm function, update the about section handling:

if (data.about) {
  document.getElementById('about-heading').value = data.about.title || '';

  // Handle the about content in the textarea
  if (data.about.paragraphs && Array.isArray(data.about.paragraphs)) {
    // Join paragraphs with newlines for the textarea
    document.getElementById('about-content').value = data.about.paragraphs.join('\n\n');
  } else if (data.about.content) {
    document.getElementById('about-content').value = data.about.content;
  }

  document.getElementById('about-button-text').value = data.about.buttonText || '';
  document.getElementById('about-image').value = data.about.imageUrl || '';
}

// Inside the updatePreview function, update the about content handling:
const aboutHeading = document.getElementById('about-heading').value;
const aboutContent = document.getElementById('about-content').value;
const aboutImage = document.getElementById('about-image').value;

document.getElementById('preview-about-title').innerHTML = aboutHeading
  ? formatTitle(aboutHeading)
  : 'About <span class="text-primary font-medium">Verdant</span>';
document.getElementById('preview-about-content').innerHTML = aboutContent
  ? formatAboutContent(aboutContent)
  : 'We believe that everyone deserves to enjoy the beauty and benefits of plants, regardless of experience level. Our mission is to make plant care accessible, enjoyable, and rewarding.';

// Add a helper function to format the about content
function formatAboutContent(content) {
  // Split by newlines and wrap each paragraph in a p tag
  return content.split('\n\n').map(para => `<p>${para}</p>`).join('');
}

// Inside the form submission handler, update the about data collection:
const formData = {
  // ...existing hero data...
  about: {
    title: document.getElementById('about-heading').value,
    content: document.getElementById('about-content').value,
    // For backward compatibility with existing paragraph structure
    paragraphs: document.getElementById('about-content').value.split('\n\n'),
    buttonText: document.getElementById('about-button-text').value,
    imageUrl: document.getElementById('about-image').value,
  },
  // ...existing guides data...
};
```

This change replaces the dynamic paragraph list with a simple textarea. In the future, you can enhance this with a proper WYSIWYG editor like TinyMCE or CKEditor by adding the editor initialization code after the DOM is loaded.

s3xtans: update the 'updatePreview' function to reload iframe or reload the whole page if it is easier.

GitHub Copilot: # Update Preview Function to Reload iframe

Let's update the `updatePreview` function to reload the iframe instead of trying to update individual elements:

```javascript
// Update preview by reloading iframe
function updatePreview() {
  // Get iframe element
  const previewIframe = document.querySelector('#preview-section iframe');

  if (previewIframe) {
    // Create temporary data object from form values
    const tempData = {
      hero: {
        title: document.getElementById('hero-heading').value,
        description: document.getElementById('hero-subheading').value,
        buttonText: document.getElementById('hero-button-text').value,
        imageUrl: document.getElementById('hero-image').value,
      },
      about: {
        title: document.getElementById('about-heading').value,
        content: document.getElementById('about-content').value,
        paragraphs: document.getElementById('about-content').value.split('\n\n'),
        buttonText: document.getElementById('about-button-text').value,
        imageUrl: document.getElementById('about-image').value,
      },
      guides: {
        title: document.getElementById('guides-heading').value,
        description: document.getElementById('guides-subheading').value,
      }
    };

    // Store the temp data in localStorage so the iframe can access it
    localStorage.setItem('verdant_preview_data', JSON.stringify(tempData));

    // Add a timestamp to force cache refresh
    const timestamp = new Date().getTime();
    const currentSrc = previewIframe.src.split('?')[0];
    previewIframe.src = `${currentSrc}?preview=true&t=${timestamp}`;
  }
}
```

This approach does the following:

1. Creates a temporary data object containing all the current form values
2. Stores this data in localStorage, which the iframe content can check for
3. Reloads the iframe with cache-busting parameters (timestamp)

To fully implement this, the preview page (loaded in the iframe) would need a script that checks for the preview data in localStorage and applies it to the page. Here's how you might do that on the frontend side:

```javascript
// Add this script to the main site to enable preview functionality
// filepath: suggestion for /d:/laragon/www/verdant/assets/js/preview-handler.js
(function() {
  // Check if we're in preview mode
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('preview') === 'true') {
    // Get preview data from localStorage
    const previewData = localStorage.getItem('verdant_preview_data');

    if (previewData) {
      try {
        const data = JSON.parse(previewData);

        // Apply preview data to the page
        applyPreviewChanges(data);
      } catch (e) {
        console.error('Error parsing preview data:', e);
      }
    }
  }

  function applyPreviewChanges(data) {
    // Apply hero section changes
    if (data.hero) {
      const heroTitle = document.getElementById('hero-title');
      const heroDescription = document.getElementById('hero-description');
      const heroImage = document.querySelector('.hero-image img');
      const heroButton = document.querySelector('.hero-button');

      if (heroTitle && data.hero.title) heroTitle.innerHTML = formatTitle(data.hero.title);
      if (heroDescription && data.hero.description) heroDescription.textContent = data.hero.description;
      if (heroImage && data.hero.imageUrl) heroImage.src = data.hero.imageUrl;
      if (heroButton && data.hero.buttonText) heroButton.textContent = data.hero.buttonText;
    }

    // Apply about section changes
    if (data.about) {
      // Similar implementation for about section
    }

    // Apply guides section changes
    if (data.guides) {
      // Similar implementation for guides section
    }
  }

  // Helper function to format titles with highlighting
  function formatTitle(title) {
    // Look for words to highlight between * characters, like *word*
    return title.replace(/\*(.*?)\*/g, '<span class="text-primary font-medium">$1</span>');
  }
})();
```

This solution provides a clean approach to previewing changes without implementing direct DOM manipulation from the admin panel.

s3xtans: update getdefaultdata and populateForm to have the same structure as sections.json

GitHub Copilot: # Updating to Match sections.json Structure

Let me update the `getDefaultData` and `populateForm` functions to match the structure in your sections.json file:

```javascript
// Populate form with data
function populateForm(data) {
  // Check if data is in the expected structure
  const sections = data.sections || [];

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
  }

  // Populate section selector
  populateSectionSelector(sections);
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

// Update form submission to match the new structure
form.addEventListener('submit', function (event) {
  event.preventDefault();

  // Get the current sections data
  let currentData;
  try {
    const response = await fetch('config/sections.json');
    currentData = await response.json();
  } catch (error) {
    console.error('Error loading current data:', error);
    currentData = getDefaultData();
  }

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
    sections[aboutIndex].content.paragraphs = document.getElementById('about-content').value.split('\n\n');
    sections[aboutIndex].content.buttonText = document.getElementById('about-button-text').value;
    sections[aboutIndex].content.image = document.getElementById('about-image').value;
  }

  // Update Guides section
  const guidesIndex = sections.findIndex(section => section.id === 'care-guides');
  if (guidesIndex >= 0) {
    sections[guidesIndex].content.heading = document.getElementById('guides-heading').value;
    sections[guidesIndex].content.subheading = document.getElementById('guides-subheading').value;
  }

  // Display save confirmation
  saveData({ sections });
});
```

This update:

1. Restructures `getDefaultData()` to match the exact format of sections.json
2. Updates `populateForm()` to handle the new structure with section IDs and nested content
3. Adds a new `populateSectionSelector()` function to fill the dropdown with section names
4. Updates the form submission handler to maintain the sections.json structure when saving

The code now properly handles data from sections.json and will maintain that structure when saving changes. Note that I've added async/await to the form submission handler since it's fetching the current data before updating it.
