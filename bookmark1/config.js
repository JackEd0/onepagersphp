// Configuration file for Bookmark Manager
const CONFIG = {
    // Environment settings
    ENVIRONMENT: 'dev', // Change to 'live' for production
    
    // Logging settings
    LOG_LEVEL: 'info', // Options: 'debug', 'info', 'warn', 'error'
    
    // Application settings
    APP_NAME: 'Bookmark Manager',
    VERSION: '1.0.0',
    
    // Data settings
    DATA_FILE: 'bookmarks-data.json',
    
    // UI settings
    ITEMS_PER_PAGE: 20,
    SEARCH_DELAY: 300, // milliseconds
    
    // Feature flags
    FEATURES: {
        SAMPLE_DATA: true,
        KEYBOARD_SHORTCUTS: true,
        MOBILE_SUPPORT: true,
        COLLECTIONS: true,
        TAGS: true,
        FAVORITES: true
    }
};

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CONFIG;
} 