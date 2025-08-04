# Modern Bookmark Manager

A beautiful, responsive bookmark manager built with Tailwind CSS and vanilla JavaScript. Features a modern design with big white spaces and JSON file storage.

## Features

- 🎨 **Modern Design**: Clean, minimalist interface with Tailwind CSS
- 📱 **Fully Responsive**: Works perfectly on desktop, tablet, and mobile
- 🗂️ **Collections**: Organize bookmarks into custom collections
- ⭐ **Favorites**: Mark important bookmarks as favorites
- 🔍 **Search**: Find bookmarks quickly with real-time search
- 🏷️ **Tags**: Add tags to categorize your bookmarks
- 💾 **JSON Storage**: Data is saved to a JSON file via PHP backend
- ⌨️ **Keyboard Shortcuts**: Quick access with keyboard shortcuts

## Keyboard Shortcuts

- `Ctrl/Cmd + N`: Add new bookmark
- `Ctrl/Cmd + K`: Focus search bar
- `Escape`: Close modals and mobile menu

## Setup

1. **Requirements**: You need a web server with PHP support (like XAMPP, WAMP, or any hosting service)

2. **Installation**:
   - Upload all files to your web server directory
   - Make sure the directory has write permissions for the JSON file
   - Access `index.html` through your web server (not directly as a file)

3. **File Structure**:
   ```
   bookmark1/
   ├── index.html          # Main application
   ├── script.js           # JavaScript functionality
   ├── save-bookmarks.php  # PHP backend for data storage
   ├── bookmarks-data.json # Data file (created automatically)
   └── README.md           # This file
   ```

## Usage

### Adding Bookmarks
1. Click the "Add Bookmark" button or use `Ctrl/Cmd + N`
2. Fill in the title and URL (required)
3. Optionally add a description, collection, and tags
4. Click "Add Bookmark"

### Managing Collections
1. Click "New Collection" in the sidebar
2. Enter a name and optional description
3. Collections appear in the sidebar for easy filtering

### Searching and Filtering
- Use the search bar to find bookmarks by title, URL, description, or tags
- Click on navigation items to filter by:
  - All Bookmarks
  - Favorites
  - Recent (last 20)
  - Collections

### Mobile Usage
- Tap the hamburger menu to open the sidebar
- All features work seamlessly on mobile devices
- Responsive design adapts to any screen size

## Data Storage

Bookmarks are stored in `bookmarks-data.json` with the following structure:

```json
{
  "bookmarks": [
    {
      "id": "unique_id",
      "title": "Bookmark Title",
      "url": "https://example.com",
      "description": "Optional description",
      "collectionId": "collection_id_or_null",
      "tags": ["tag1", "tag2"],
      "favorite": false,
      "createdAt": "2024-01-01T00:00:00.000Z",
      "updatedAt": "2024-01-01T00:00:00.000Z"
    }
  ],
  "collections": [
    {
      "id": "unique_id",
      "name": "Collection Name",
      "description": "Optional description",
      "createdAt": "2024-01-01T00:00:00.000Z"
    }
  ],
  "lastUpdated": "2024-01-01T00:00:00.000Z"
}
```

## Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge

## Customization

The design uses Tailwind CSS classes, making it easy to customize:

- Colors: Modify the color classes (e.g., `bg-blue-600`, `text-gray-900`)
- Spacing: Adjust padding and margins (e.g., `p-8`, `mb-6`)
- Typography: Change font sizes and weights (e.g., `text-2xl`, `font-bold`)

## Troubleshooting

1. **Data not saving**: Check that PHP has write permissions to the directory
2. **Page not loading**: Make sure you're accessing through a web server, not as a local file
3. **Mobile menu not working**: Ensure JavaScript is enabled in your browser

## License

This project is open source and available under the MIT License. 