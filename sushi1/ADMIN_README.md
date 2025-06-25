# Sakura Sushi Admin System

This admin system allows you to easily edit the content of your sushi restaurant website without touching the HTML code.

## Files Overview

- `index.html` - The main website (now with dynamic content loading)
- `admin.html` - The admin panel interface
- `site-config.json` - Configuration file containing all editable content
- `save-config.php` - PHP script to save changes from the admin panel
- `styles.css` - Website styling

## How to Use

### 1. Access the Admin Panel
Open `admin.html` in your web browser. This will load the admin interface where you can edit all website content.

### 2. Navigate Between Sections
Use the sidebar navigation to switch between different sections:
- **Site Settings** - Website title, logo, and brand name
- **Navigation** - Menu items and links
- **Hero Section** - Main banner content and call-to-action buttons
- **Menu Items** - Restaurant menu with prices, descriptions, and emojis
- **Testimonials** - Customer reviews and ratings
- **Contact Info** - Address, phone, email, and hours

### 3. Edit Content
- Click on any field to edit the content
- For navigation items, menu items, and testimonials, you can add/remove items using the buttons
- All changes are made in real-time in the form

### 4. Save Changes
Click the "Save Changes" button to save your modifications. The system will:
- Validate all data
- Create a backup of the current configuration
- Save the new configuration to `site-config.json`
- Show a success message

### 5. Preview Changes
Click "Preview Site" to open the main website in a new tab and see your changes.

## Features

### Dynamic Content Loading
The main website (`index.html`) automatically loads content from `site-config.json` when the page loads.

### Data Validation
The PHP script validates and sanitizes all input data to prevent security issues.

### Backup System
A backup of the current configuration is created before saving new changes.

### User-Friendly Interface
- Clean, modern interface similar to WordPress admin
- Tabbed navigation for easy organization
- Real-time form updates
- Add/remove functionality for dynamic content

## Technical Details

### Data Structure
The `site-config.json` file contains all editable content organized into sections:
- Site information (title, logo, brand)
- Navigation menu items
- Hero section content and buttons
- Gallery/menu items with prices and descriptions
- Customer testimonials
- Contact information
- Footer content

### Security
- All user input is sanitized using `htmlspecialchars()`
- JSON validation before processing
- Backup creation before saving
- Proper HTTP headers and error handling

### Browser Compatibility
- Works with all modern browsers
- Uses Tailwind CSS for styling
- Vanilla JavaScript for functionality
- No external dependencies except Tailwind CDN

## Troubleshooting

### Changes Not Appearing
1. Make sure you clicked "Save Changes" in the admin panel
2. Refresh the main website page
3. Check browser console for any JavaScript errors

### Admin Panel Not Loading
1. Ensure all files are in the same directory
2. Check that your web server supports PHP
3. Verify file permissions allow reading/writing

### Save Errors
1. Check that the web server has write permissions to the directory
2. Ensure PHP is properly configured
3. Check the browser console for error messages

## File Permissions
Make sure your web server has read/write permissions for:
- `site-config.json`
- `save-config.php`

## Support
If you encounter any issues, check the browser console for error messages and ensure all files are properly uploaded to your web server. 