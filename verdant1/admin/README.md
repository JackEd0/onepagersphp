# Plant Care Admin

This project provides an admin interface for customizing the sections of the existing plant care website. It allows users to update content, styles, and settings for different sections of the site easily.

## Project Structure

```text
plant-care-admin
├── admin.html               # Admin interface for customization
├── assets
│   ├── css
│   │   └── admin-styles.css # CSS styles for the admin page
│   └── js
│       └── admin.js         # JavaScript functionality for the admin page
├── config
│   └── site.json        # Configuration for website sections
├── uploads
│   └── .gitkeep             # Keeps the uploads directory tracked by Git
└── README.md                # Documentation for the project
```

## Setup Instructions

1. **Clone the Repository**:
   Clone this repository to your local machine using:

   ```sh
   git clone <repository-url>
   ```

2. **Navigate to the Project Directory**:

   ```sh
   cd plant-care-admin
   ```

3. **Open `admin.html`**:
   Open the `admin.html` file in your web browser to access the admin interface.

4. **Customize Sections**:
   Use the forms and controls provided in the admin interface to update the content and settings of the plant care website.

## Usage Guidelines

- The `admin.html` file serves as the main interface for customization.
- The `assets/css/admin-styles.css` file contains styles specific to the admin page, ensuring a user-friendly layout.
- The `assets/js/admin.js` file handles the dynamic functionality of the admin interface, including form submissions and AJAX calls.
- The `config/site.json` file stores the default values and settings for the website sections, which can be modified through the admin interface.

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue for any enhancements or bug fixes.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.
