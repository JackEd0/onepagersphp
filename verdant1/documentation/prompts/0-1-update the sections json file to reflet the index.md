s3xtans: update the sections.json file to reflet the index.html data

GitHub Copilot: # JSON Update to Match HTML Content

I'll update the sections.json file to fully reflect what's shown in the HTML:

```json
{
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
                    "Our mission is to make plant care accessible, enjoyable, and rewarding.",
                    "Founded by a team of horticulture experts and plant enthusiasts, Verdant provides scientifically-based care advice while keeping things simple enough for beginners."
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
                "guides": [
                    {
                        "title": "Watering",
                        "description": "Learn the art of proper watering - when, how much, and how often for different types of plants.",
                        "image": "https://images.unsplash.com/photo-1618498732743-b9907abfdf83?q=80&w=1170&auto=format&fit=crop"
                    },
                    {
                        "title": "Light Requirements",
                        "description": "Discover how to place your plants to give them the perfect amount of sunlight they need.",
                        "image": "https://images.unsplash.com/photo-1592150621744-aca64f48394a?q=80&w=1170&auto=format&fit=crop"
                    },
                    {
                        "title": "Soil & Fertilizers",
                        "description": "Understanding the right soil and nutrients that will help your plants flourish all year long.",
                        "image": "https://images.unsplash.com/photo-1566836610593-62a64888a216?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80"
                    }
                ]
            }
        },
        {
            "id": "tips",
            "title": "Expert Tips Section",
            "content": {
                "heading": "Expert Tips & Tricks",
                "subheading": "Simple solutions to common plant problems",
                "tips": [
                    {
                        "title": "Rotate Your Plants Regularly",
                        "description": "Plants grow toward light sources, so rotate them a quarter turn weekly to keep them growing evenly and balanced."
                    },
                    {
                        "title": "Use Room Temperature Water",
                        "description": "Cold water can shock plant roots. Always use room temperature water for a happier, healthier plant."
                    },
                    {
                        "title": "Clean Those Leaves",
                        "description": "Dusty leaves can block sunlight and prevent proper photosynthesis. Wipe them gently with a damp cloth monthly."
                    },
                    {
                        "title": "Group Plants Together",
                        "description": "Plants grouped together create a microclimate with higher humidity, which benefits most houseplants."
                    }
                ]
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
                "testimonials": [
                    {
                        "name": "Sarah J.",
                        "role": "Plant Parent of 15",
                        "quote": "The watering guide completely changed how I care for my plants. My fiddle leaf fig that was struggling is now thriving with new leaves!",
                        "image": "https://randomuser.me/api/portraits/women/45.jpg"
                    },
                    {
                        "name": "Michael T.",
                        "role": "Apartment Gardener",
                        "quote": "As a beginner, I was killing every plant I brought home. The simple tips on this site helped me create a thriving indoor jungle in just months.",
                        "image": "https://randomuser.me/api/portraits/men/32.jpg"
                    },
                    {
                        "name": "Elena R.",
                        "role": "Office Plant Enthusiast",
                        "quote": "I've transformed our office with plants thanks to the lighting recommendations. Everyone comments on how much more peaceful and productive the space feels now.",
                        "image": "https://randomuser.me/api/portraits/women/68.jpg"
                    }
                ]
            }
        }
    ]
}
```

Key changes made:

1. Added the third paragraph to the About section that was in the HTML
2. Added headings and subheadings to the Care Guides, Tips, and Testimonials sections
3. Added a new Newsletter section that was present in the HTML but missing in the JSON
4. Maintained all content and structure from the original sections

s3xtans: update the admin to be able to edit all data from sections.json

GitHub Copilot: # Admin Panel Update for Complete Section Editing

I'll update the admin panel to include form fields for all sections in the sections.json file. The current implementation only handles a few sections partially.

```html
verdant/admin/index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Care Admin</title>
    <!-- Added Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#2D6A4F',
                        'primary-light': '#40916C',
                        'accent': '#95D5B2',
                        'light': '#D8F3DC',
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-4 py-8">
        <!-- Header with layout controls -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h1 class="text-3xl font-semibold text-primary">Verdant Admin Panel</h1>

            <div class="flex items-center mt-4 md:mt-0 space-x-2 bg-white p-2 rounded-lg shadow-sm">
                <button id="default-view" class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium" title="Show both panels">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    Default
                </button>
                <button id="editor-view" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-100 rounded-md text-sm font-medium" title="Show only the editor">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editor
                </button>
                <button id="preview-view" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-100 rounded-md text-sm font-medium" title="Show only the preview">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Preview
                </button>
            </div>
        </div>

        <div id="layout-container" class="flex flex-col lg:flex-row gap-8">
            <!-- Form Section -->
            <div id="form-section" class="lg:w-1/2">
                <form id="customization-form" class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-medium mb-6 pb-2 border-b border-gray-200">Customize Sections</h2>

                    <!-- Section selector -->
                    <div class="mb-6">
                        <label for="section-selector" class="block text-sm font-medium mb-1 text-gray-700">Select Section to Edit:</label>
                        <select id="section-selector" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="hero">Hero Section</option>
                            <option value="about">About Section</option>
                            <option value="care-guides">Care Guides Section</option>
                            <option value="tips">Expert Tips Section</option>
                            <option value="newsletter">Newsletter Section</option>
                            <option value="testimonials">Testimonials Section</option>
                        </select>
                    </div>

                    <!-- Hero Section -->
                    <div id="hero-section-form" class="section-form mb-8">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Hero Section</h3>

                        <div class="mb-4">
                            <label for="hero-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="hero-heading" name="hero-heading" placeholder="Enter hero heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="hero-subheading" class="block text-sm font-medium mb-1 text-gray-700">Subheading:</label>
                            <textarea id="hero-subheading" name="hero-subheading" placeholder="Enter hero subheading" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="hero-button-text" class="block text-sm font-medium mb-1 text-gray-700">Button Text:</label>
                            <input type="text" id="hero-button-text" name="hero-button-text" placeholder="Enter button text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="hero-image" class="block text-sm font-medium mb-1 text-gray-700">Image URL:</label>
                            <input type="text" id="hero-image" name="hero-image" placeholder="Enter image URL"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <div class="mt-2">
                                <div id="hero-image-preview" class="bg-gray-100 h-40 rounded-md flex items-center justify-center overflow-hidden">
                                    <span class="text-gray-400">Image preview will appear here</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div id="about-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">About Section</h3>

                        <div class="mb-4">
                            <label for="about-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="about-heading" name="about-heading" placeholder="Enter about heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div id="about-paragraphs-container">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Paragraphs:</label>
                            <div class="space-y-3" id="about-paragraphs-list">
                                <!-- Paragraphs will be added dynamically here -->
                            </div>
                            <button type="button" id="add-paragraph-btn" class="mt-2 text-sm bg-accent hover:bg-accent/80 text-primary font-medium py-1 px-3 rounded">
                                + Add Paragraph
                            </button>
                        </div>

                        <div class="mb-4 mt-4">
                            <label for="about-button-text" class="block text-sm font-medium mb-1 text-gray-700">Button Text:</label>
                            <input type="text" id="about-button-text" name="about-button-text" placeholder="Enter button text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="about-image" class="block text-sm font-medium mb-1 text-gray-700">Image URL:</label>
                            <input type="text" id="about-image" name="about-image" placeholder="Enter about image URL"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <div class="mt-2">
                                <div id="about-image-preview" class="bg-gray-100 h-40 rounded-md flex items-center justify-center overflow-hidden">
                                    <span class="text-gray-400">Image preview will appear here</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Care Guides Section -->
                    <div id="care-guides-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Care Guides Section</h3>

                        <div class="mb-4">
                            <label for="guides-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="guides-heading" name="guides-heading" placeholder="Enter guides heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="guides-subheading" class="block text-sm font-medium mb-1 text-gray-700">Subheading:</label>
                            <textarea id="guides-subheading" name="guides-subheading" placeholder="Enter guides subheading" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Guides:</label>
                            <div id="guides-list" class="space-y-6">
                                <!-- Guides will be added dynamically here -->
                            </div>
                            <button type="button" id="add-guide-btn" class="mt-3 text-sm bg-accent hover:bg-accent/80 text-primary font-medium py-1 px-3 rounded">
                                + Add Guide
                            </button>
                        </div>
                    </div>

                    <!-- Expert Tips Section -->
                    <div id="tips-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Expert Tips Section</h3>

                        <div class="mb-4">
                            <label for="tips-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="tips-heading" name="tips-heading" placeholder="Enter tips heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="tips-subheading" class="block text-sm font-medium mb-1 text-gray-700">Subheading:</label>
                            <textarea id="tips-subheading" name="tips-subheading" placeholder="Enter tips subheading" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Tips:</label>
                            <div id="tips-list" class="space-y-6">
                                <!-- Tips will be added dynamically here -->
                            </div>
                            <button type="button" id="add-tip-btn" class="mt-3 text-sm bg-accent hover:bg-accent/80 text-primary font-medium py-1 px-3 rounded">
                                + Add Tip
                            </button>
                        </div>
                    </div>

                    <!-- Newsletter Section -->
                    <div id="newsletter-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Newsletter Section</h3>

                        <div class="mb-4">
                            <label for="newsletter-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="newsletter-heading" name="newsletter-heading" placeholder="Enter newsletter heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="newsletter-description" class="block text-sm font-medium mb-1 text-gray-700">Description:</label>
                            <textarea id="newsletter-description" name="newsletter-description" placeholder="Enter newsletter description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="newsletter-button-text" class="block text-sm font-medium mb-1 text-gray-700">Button Text:</label>
                            <input type="text" id="newsletter-button-text" name="newsletter-button-text" placeholder="Enter button text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="newsletter-placeholder" class="block text-sm font-medium mb-1 text-gray-700">Input Placeholder:</label>
                            <input type="text" id="newsletter-placeholder" name="newsletter-placeholder" placeholder="Enter input placeholder text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>

                    <!-- Testimonials Section -->
                    <div id="testimonials-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Testimonials Section</h3>

                        <div class="mb-4">
                            <label for="testimonials-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="testimonials-heading" name="testimonials-heading" placeholder="Enter testimonials heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="testimonials-subheading" class="block text-sm font-medium mb-1 text-gray-700">Subheading:</label>
                            <textarea id="testimonials-subheading" name="testimonials-subheading" placeholder="Enter testimonials subheading" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Testimonials:</label>
                            <div id="testimonials-list" class="space-y-6">
                                <!-- Testimonials will be added dynamically here -->
                            </div>
                            <button type="button" id="add-testimonial-btn" class="mt-3 text-sm bg-accent hover:bg-accent/80 text-primary font-medium py-1 px-3 rounded">
                                + Add Testimonial
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary-light text-white py-3 px-4 rounded-md transition-colors">
                        Save Changes
                    </button>
                </form>
            </div>

            <!-- Preview Section -->
            <div id="preview-section-container" class="lg:w-1/2">
                <div class="bg-white rounded-lg shadow-md p-6 h-full">
                    <h2 class="text-xl font-medium mb-6 pb-2 border-b border-gray-200">Live Preview</h2>

                    <div id="preview-section" class="overflow-auto h-screen max-h-[80vh] border border-gray-200 rounded-md">
                        <iframe src="http://verdant.test/" frameborder="0" class="w-full h-full"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/admin.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                [defaultViewBtn, editorViewBtn, previewViewBtn].forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                });

                // Set active button
                activeBtn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                activeBtn.classList.add('bg-primary', 'text-white');
            }

            // Default view (both panels)
            defaultViewBtn.addEventListener('click', function() {
                formSection.classList.remove('lg:w-full', 'hidden');
                previewSectionContainer.classList.remove('lg:w-full', 'hidden');
                formSection.classList.add('lg:w-1/2');
                previewSectionContainer.classList.add('lg:w-1/2');
                layoutContainer.classList.add('lg:flex-row');
                setActiveButton(defaultViewBtn);
            });

            // Editor-only view
            editorViewBtn.addEventListener('click', function() {
                formSection.classList.remove('lg:w-1/2', 'hidden');
                formSection.classList.add('lg:w-full');
                previewSectionContainer.classList.add('hidden');
                previewSectionContainer.classList.remove('lg:w-1/2', 'lg:w-full');
                layoutContainer.classList.remove('lg:flex-row');
                setActiveButton(editorViewBtn);
            });

            // Preview-only view
            previewViewBtn.addEventListener('click', function() {
                previewSectionContainer.classList.remove('lg:w-1/2', 'hidden');
                previewSectionContainer.classList.add('lg:w-full');
                formSection.classList.add('hidden');
                formSection.classList.remove('lg:w-1/2', 'lg:w-full');
                layoutContainer.classList.remove('lg:flex-row');
                setActiveButton(previewViewBtn);
            });

            // Section selector functionality
            const sectionSelector = document.getElementById('section-selector');
            const sectionForms = document.querySelectorAll('.section-form');

            sectionSelector.addEventListener('change', function() {
                const selectedSection = this.value;

                // Hide all section forms
                sectionForms.forEach(form => {
                    form.classList.add('hidden');
                });

                // Show selected section form
                document.getElementById(`${selectedSection}-section-form`).classList.remove('hidden');
            });

            // Load data from sections.json
            fetch('config/sections.json')
                .then(response => response.json())
                .then(data => {
                    // Populate form with data
                    populateFormWithData(data);
                })
                .catch(error => {
                    console.error('Error loading sections data:', error);
                });

            // Helper function to create dynamic form elements
            function createDynamicFormElements() {
                // About section - paragraphs
                document.getElementById('add-paragraph-btn').addEventListener('click', function() {
                    addParagraphField();
                });

                // Care guides - guides
                document.getElementById('add-guide-btn').addEventListener('click', function() {
                    addGuideField();
                });

                // Tips - tips
                document.getElementById('add-tip-btn').addEventListener('click', function() {
                    addTipField();
                });

                // Testimonials - testimonials
                document.getElementById('add-testimonial-btn').addEventListener('click', function() {
                    addTestimonialField();
                });
            }

            // Functions to add dynamic fields
            function addParagraphField(value = '') {
                const paragraphsContainer = document.getElementById('about-paragraphs-list');
                const index = paragraphsContainer.children.length;

                const paragraphDiv = document.createElement('div');
                paragraphDiv.className = 'flex items-start gap-2';
                paragraphDiv.innerHTML = `
                    <textarea name="about-paragraph-${index}" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                              rows="2" placeholder="Enter paragraph">${value}</textarea>
                    <button type="button" class="remove-paragraph-btn flex-shrink-0 text-red-500 hover:text-red-700 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;

                paragraphsContainer.appendChild(paragraphDiv);

                // Add event listener to remove button
                paragraphDiv.querySelector('.remove-paragraph-btn').addEventListener('click', function() {
                    paragraphDiv.remove();
                });
            }

            function addGuideField(guide = {}) {
                const guidesContainer = document.getElementById('guides-list');
                const index = guidesContainer.children.length;

                const guideDiv = document.createElement('div');
                guideDiv.className = 'p-4 border border-gray-200 rounded-md';
                guideDiv.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="font-medium">Guide ${index + 1}</h4>
                        <button type="button" class="remove-guide-btn text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700">Title:</label>
                            <input type="text" name="guide-title-${index}" value="${guide.title || ''}" placeholder="Guide title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700">Description:</label>
                            <textarea name="guide-description-${index}" rows="2" placeholder="Guide description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">${guide.description || ''}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700">Image URL:</label>
                            <input type="text" name="guide-image-${index}" value="${guide.image || ''}" placeholder="Image URL" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                            <div class="mt-2 bg-gray-100 h-32 rounded-md overflow-hidden guide-image-preview">
                                ${guide.image ? `<img src="${guide.image}" class="w-full h-full object-cover" alt="Guide preview">` : '<span class="flex h-full items-center justify-center text-gray-400">Image preview</span>'}
                            </div>
                        </div>
                    </div>
                `;

                guidesContainer.appendChild(guideDiv);

                // Add event listener to remove button
                guideDiv.querySelector('.remove-guide-btn').addEventListener('click', function() {
                    guideDiv.remove();
                });

                // Add event listener for image preview
                const imageInput = guideDiv.querySelector(`input[name="guide-image-${index}"]`);
                const imagePreview = guideDiv.querySelector('.guide-image-preview');

                imageInput.addEventListener('input', function() {
                    updateImagePreview(this.value, imagePreview);
                });
            }

            function addTipField(tip = {}) {
                const tipsContainer = document.getElementById('tips-list');
                const index = tipsContainer.children.length;

                const tipDiv = document.createElement('div');
                tipDiv.className = 'p-4 border border-gray-200 rounded-md';
                tipDiv.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="font-medium">Tip ${index + 1}</h4>
                        <button type="button" class="removeverdant/admin/index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Care Admin</title>
    <!-- Added Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#2D6A4F',
                        'primary-light': '#40916C',
                        'accent': '#95D5B2',
                        'light': '#D8F3DC',
                    },
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-4 py-8">
        <!-- Header with layout controls -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h1 class="text-3xl font-semibold text-primary">Verdant Admin Panel</h1>

            <div class="flex items-center mt-4 md:mt-0 space-x-2 bg-white p-2 rounded-lg shadow-sm">
                <button id="default-view" class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium" title="Show both panels">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    Default
                </button>
                <button id="editor-view" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-100 rounded-md text-sm font-medium" title="Show only the editor">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editor
                </button>
                <button id="preview-view" class="px-4 py-2 bg-white text-gray-700 hover:bg-gray-100 rounded-md text-sm font-medium" title="Show only the preview">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Preview
                </button>
            </div>
        </div>

        <div id="layout-container" class="flex flex-col lg:flex-row gap-8">
            <!-- Form Section -->
            <div id="form-section" class="lg:w-1/2">
                <form id="customization-form" class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-medium mb-6 pb-2 border-b border-gray-200">Customize Sections</h2>

                    <!-- Section selector -->
                    <div class="mb-6">
                        <label for="section-selector" class="block text-sm font-medium mb-1 text-gray-700">Select Section to Edit:</label>
                        <select id="section-selector" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="hero">Hero Section</option>
                            <option value="about">About Section</option>
                            <option value="care-guides">Care Guides Section</option>
                            <option value="tips">Expert Tips Section</option>
                            <option value="newsletter">Newsletter Section</option>
                            <option value="testimonials">Testimonials Section</option>
                        </select>
                    </div>

                    <!-- Hero Section -->
                    <div id="hero-section-form" class="section-form mb-8">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Hero Section</h3>

                        <div class="mb-4">
                            <label for="hero-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="hero-heading" name="hero-heading" placeholder="Enter hero heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="hero-subheading" class="block text-sm font-medium mb-1 text-gray-700">Subheading:</label>
                            <textarea id="hero-subheading" name="hero-subheading" placeholder="Enter hero subheading" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="hero-button-text" class="block text-sm font-medium mb-1 text-gray-700">Button Text:</label>
                            <input type="text" id="hero-button-text" name="hero-button-text" placeholder="Enter button text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="hero-image" class="block text-sm font-medium mb-1 text-gray-700">Image URL:</label>
                            <input type="text" id="hero-image" name="hero-image" placeholder="Enter image URL"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <div class="mt-2">
                                <div id="hero-image-preview" class="bg-gray-100 h-40 rounded-md flex items-center justify-center overflow-hidden">
                                    <span class="text-gray-400">Image preview will appear here</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Section -->
                    <div id="about-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">About Section</h3>

                        <div class="mb-4">
                            <label for="about-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="about-heading" name="about-heading" placeholder="Enter about heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div id="about-paragraphs-container">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Paragraphs:</label>
                            <div class="space-y-3" id="about-paragraphs-list">
                                <!-- Paragraphs will be added dynamically here -->
                            </div>
                            <button type="button" id="add-paragraph-btn" class="mt-2 text-sm bg-accent hover:bg-accent/80 text-primary font-medium py-1 px-3 rounded">
                                + Add Paragraph
                            </button>
                        </div>

                        <div class="mb-4 mt-4">
                            <label for="about-button-text" class="block text-sm font-medium mb-1 text-gray-700">Button Text:</label>
                            <input type="text" id="about-button-text" name="about-button-text" placeholder="Enter button text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="about-image" class="block text-sm font-medium mb-1 text-gray-700">Image URL:</label>
                            <input type="text" id="about-image" name="about-image" placeholder="Enter about image URL"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <div class="mt-2">
                                <div id="about-image-preview" class="bg-gray-100 h-40 rounded-md flex items-center justify-center overflow-hidden">
                                    <span class="text-gray-400">Image preview will appear here</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Care Guides Section -->
                    <div id="care-guides-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Care Guides Section</h3>

                        <div class="mb-4">
                            <label for="guides-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="guides-heading" name="guides-heading" placeholder="Enter guides heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="guides-subheading" class="block text-sm font-medium mb-1 text-gray-700">Subheading:</label>
                            <textarea id="guides-subheading" name="guides-subheading" placeholder="Enter guides subheading" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Guides:</label>
                            <div id="guides-list" class="space-y-6">
                                <!-- Guides will be added dynamically here -->
                            </div>
                            <button type="button" id="add-guide-btn" class="mt-3 text-sm bg-accent hover:bg-accent/80 text-primary font-medium py-1 px-3 rounded">
                                + Add Guide
                            </button>
                        </div>
                    </div>

                    <!-- Expert Tips Section -->
                    <div id="tips-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Expert Tips Section</h3>

                        <div class="mb-4">
                            <label for="tips-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="tips-heading" name="tips-heading" placeholder="Enter tips heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="tips-subheading" class="block text-sm font-medium mb-1 text-gray-700">Subheading:</label>
                            <textarea id="tips-subheading" name="tips-subheading" placeholder="Enter tips subheading" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Tips:</label>
                            <div id="tips-list" class="space-y-6">
                                <!-- Tips will be added dynamically here -->
                            </div>
                            <button type="button" id="add-tip-btn" class="mt-3 text-sm bg-accent hover:bg-accent/80 text-primary font-medium py-1 px-3 rounded">
                                + Add Tip
                            </button>
                        </div>
                    </div>

                    <!-- Newsletter Section -->
                    <div id="newsletter-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Newsletter Section</h3>

                        <div class="mb-4">
                            <label for="newsletter-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="newsletter-heading" name="newsletter-heading" placeholder="Enter newsletter heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="newsletter-description" class="block text-sm font-medium mb-1 text-gray-700">Description:</label>
                            <textarea id="newsletter-description" name="newsletter-description" placeholder="Enter newsletter description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="newsletter-button-text" class="block text-sm font-medium mb-1 text-gray-700">Button Text:</label>
                            <input type="text" id="newsletter-button-text" name="newsletter-button-text" placeholder="Enter button text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="newsletter-placeholder" class="block text-sm font-medium mb-1 text-gray-700">Input Placeholder:</label>
                            <input type="text" id="newsletter-placeholder" name="newsletter-placeholder" placeholder="Enter input placeholder text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>

                    <!-- Testimonials Section -->
                    <div id="testimonials-section-form" class="section-form mb-8 hidden">
                        <h3 class="text-lg font-medium mb-4 text-primary-light">Testimonials Section</h3>

                        <div class="mb-4">
                            <label for="testimonials-heading" class="block text-sm font-medium mb-1 text-gray-700">Heading:</label>
                            <input type="text" id="testimonials-heading" name="testimonials-heading" placeholder="Enter testimonials heading"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>

                        <div class="mb-4">
                            <label for="testimonials-subheading" class="block text-sm font-medium mb-1 text-gray-700">Subheading:</label>
                            <textarea id="testimonials-subheading" name="testimonials-subheading" placeholder="Enter testimonials subheading" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-700">Testimonials:</label>
                            <div id="testimonials-list" class="space-y-6">
                                <!-- Testimonials will be added dynamically here -->
                            </div>
                            <button type="button" id="add-testimonial-btn" class="mt-3 text-sm bg-accent hover:bg-accent/80 text-primary font-medium py-1 px-3 rounded">
                                + Add Testimonial
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary-light text-white py-3 px-4 rounded-md transition-colors">
                        Save Changes
                    </button>
                </form>
            </div>

            <!-- Preview Section -->
            <div id="preview-section-container" class="lg:w-1/2">
                <div class="bg-white rounded-lg shadow-md p-6 h-full">
                    <h2 class="text-xl font-medium mb-6 pb-2 border-b border-gray-200">Live Preview</h2>

                    <div id="preview-section" class="overflow-auto h-screen max-h-[80vh] border border-gray-200 rounded-md">
                        <iframe src="http://verdant.test/" frameborder="0" class="w-full h-full"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/admin.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                [defaultViewBtn, editorViewBtn, previewViewBtn].forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                });

                // Set active button
                activeBtn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-100');
                activeBtn.classList.add('bg-primary', 'text-white');
            }

            // Default view (both panels)
            defaultViewBtn.addEventListener('click', function() {
                formSection.classList.remove('lg:w-full', 'hidden');
                previewSectionContainer.classList.remove('lg:w-full', 'hidden');
                formSection.classList.add('lg:w-1/2');
                previewSectionContainer.classList.add('lg:w-1/2');
                layoutContainer.classList.add('lg:flex-row');
                setActiveButton(defaultViewBtn);
            });

            // Editor-only view
            editorViewBtn.addEventListener('click', function() {
                formSection.classList.remove('lg:w-1/2', 'hidden');
                formSection.classList.add('lg:w-full');
                previewSectionContainer.classList.add('hidden');
                previewSectionContainer.classList.remove('lg:w-1/2', 'lg:w-full');
                layoutContainer.classList.remove('lg:flex-row');
                setActiveButton(editorViewBtn);
            });

            // Preview-only view
            previewViewBtn.addEventListener('click', function() {
                previewSectionContainer.classList.remove('lg:w-1/2', 'hidden');
                previewSectionContainer.classList.add('lg:w-full');
                formSection.classList.add('hidden');
                formSection.classList.remove('lg:w-1/2', 'lg:w-full');
                layoutContainer.classList.remove('lg:flex-row');
                setActiveButton(previewViewBtn);
            });

            // Section selector functionality
            const sectionSelector = document.getElementById('section-selector');
            const sectionForms = document.querySelectorAll('.section-form');

            sectionSelector.addEventListener('change', function() {
                const selectedSection = this.value;

                // Hide all section forms
                sectionForms.forEach(form => {
                    form.classList.add('hidden');
                });

                // Show selected section form
                document.getElementById(`${selectedSection}-section-form`).classList.remove('hidden');
            });

            // Load data from sections.json
            fetch('config/sections.json')
                .then(response => response.json())
                .then(data => {
                    // Populate form with data
                    populateFormWithData(data);
                })
                .catch(error => {
                    console.error('Error loading sections data:', error);
                });

            // Helper function to create dynamic form elements
            function createDynamicFormElements() {
                // About section - paragraphs
                document.getElementById('add-paragraph-btn').addEventListener('click', function() {
                    addParagraphField();
                });

                // Care guides - guides
                document.getElementById('add-guide-btn').addEventListener('click', function() {
                    addGuideField();
                });

                // Tips - tips
                document.getElementById('add-tip-btn').addEventListener('click', function() {
                    addTipField();
                });

                // Testimonials - testimonials
                document.getElementById('add-testimonial-btn').addEventListener('click', function() {
                    addTestimonialField();
                });
            }

            // Functions to add dynamic fields
            function addParagraphField(value = '') {
                const paragraphsContainer = document.getElementById('about-paragraphs-list');
                const index = paragraphsContainer.children.length;

                const paragraphDiv = document.createElement('div');
                paragraphDiv.className = 'flex items-start gap-2';
                paragraphDiv.innerHTML = `
                    <textarea name="about-paragraph-${index}" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                              rows="2" placeholder="Enter paragraph">${value}</textarea>
                    <button type="button" class="remove-paragraph-btn flex-shrink-0 text-red-500 hover:text-red-700 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;

                paragraphsContainer.appendChild(paragraphDiv);

                // Add event listener to remove button
                paragraphDiv.querySelector('.remove-paragraph-btn').addEventListener('click', function() {
                    paragraphDiv.remove();
                });
            }

            function addGuideField(guide = {}) {
                const guidesContainer = document.getElementById('guides-list');
                const index = guidesContainer.children.length;

                const guideDiv = document.createElement('div');
                guideDiv.className = 'p-4 border border-gray-200 rounded-md';
                guideDiv.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="font-medium">Guide ${index + 1}</h4>
                        <button type="button" class="remove-guide-btn text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700">Title:</label>
                            <input type="text" name="guide-title-${index}" value="${guide.title || ''}" placeholder="Guide title" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700">Description:</label>
                            <textarea name="guide-description-${index}" rows="2" placeholder="Guide description" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">${guide.description || ''}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-gray-700">Image URL:</label>
                            <input type="text" name="guide-image-${index}" value="${guide.image || ''}" placeholder="Image URL" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
                            <div class="mt-2 bg-gray-100 h-32 rounded-md overflow-hidden guide-image-preview">
                                ${guide.image ? `<img src="${guide.image}" class="w-full h-full object-cover" alt="Guide preview">` : '<span class="flex h-full items-center justify-center text-gray-400">Image preview</span>'}
                            </div>
                        </div>
                    </div>
                `;

                guidesContainer.appendChild(guideDiv);

                // Add event listener to remove button
                guideDiv.querySelector('.remove-guide-btn').addEventListener('click', function() {
                    guideDiv.remove();
                });

                // Add event listener for image preview
                const imageInput = guideDiv.querySelector(`input[name="guide-image-${index}"]`);
                const imagePreview = guideDiv.querySelector('.guide-image-preview');

                imageInput.addEventListener('input', function() {
                    updateImagePreview(this.value, imagePreview);
                });
            }

            function addTipField(tip = {}) {
                const tipsContainer = document.getElementById('tips-list');
                const index = tipsContainer.children.length;

                const tipDiv = document.createElement('div');
                tipDiv.className = 'p-4 border border-gray-200 rounded-md';
                tipDiv.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="font-medium">Tip ${index + 1}</h4>
                        <button type="button" class="remove

Similar code found with 4 license types
