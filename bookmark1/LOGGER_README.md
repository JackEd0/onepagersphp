# Logger Service Documentation

## Overview

The Bookmark Manager application now includes a comprehensive logging service that provides environment-based logging functionality. Logs are only shown when the environment is set to 'dev', making it perfect for development and debugging while keeping production clean.

## Features

- **Environment-based logging**: Logs only appear in development mode
- **Multiple log levels**: DEBUG, INFO, WARN, ERROR, SUCCESS
- **Colored console output**: Different colors for different log levels
- **Timestamped logs**: All logs include ISO timestamps
- **Function entry/exit tracking**: Automatic function call logging
- **Performance monitoring**: Built-in performance metrics
- **User action tracking**: Log user interactions
- **Data operation logging**: Track CRUD operations
- **API call logging**: Monitor HTTP requests and responses

## Configuration

### Environment Settings

Edit `config.js` to change the environment:

```javascript
const CONFIG = {
    ENVIRONMENT: 'dev', // Change to 'live' for production
    LOG_LEVEL: 'info',  // Options: 'debug', 'info', 'warn', 'error'
    // ... other settings
};
```

### Environment Options

- **'dev'**: Shows all logs (development mode)
- **'live'**: Disables all logging (production mode)

### Log Levels

- **'debug'**: Most verbose, shows all logs
- **'info'**: Shows info, warn, error, and success logs
- **'warn'**: Shows only warnings and errors
- **'error'**: Shows only errors

## Usage Examples

### Basic Logging

```javascript
// Info logging
logger.info('Application started');

// Debug logging (only shown if log level is 'debug')
logger.debug('Processing user input', { userId: 123, action: 'click' });

// Warning logging
logger.warn('User attempted invalid action', { action: 'delete', itemId: 456 });

// Error logging
logger.error('Failed to save data', error);

// Success logging
logger.success('Data saved successfully', { recordCount: 10 });
```

### Function Tracking

```javascript
function processData(data) {
    logger.functionEntry('processData', { dataSize: data.length });
    
    // ... function logic ...
    
    logger.functionExit('processData', { result: processedData });
    return processedData;
}
```

### User Actions

```javascript
// Log user interactions
logger.userAction('Button clicked', { buttonId: 'addBookmark', timestamp: Date.now() });
logger.userAction('Search performed', { query: 'javascript', resultCount: 5 });
```

### Data Operations

```javascript
// Log CRUD operations
logger.dataOperation('create', 'bookmark', { id: '123', title: 'Example' });
logger.dataOperation('update', 'collection', { id: '456', name: 'Updated Name' });
logger.dataOperation('delete', 'bookmark', { id: '789' });
```

### API Calls

```javascript
// Log API requests
logger.apiCall('POST', '/api/bookmarks', { title: 'New Bookmark' });

// Log API responses
logger.apiResponse('POST', '/api/bookmarks', 201, { id: '123' });
```

### Performance Monitoring

```javascript
const startTime = performance.now();
// ... perform operation ...
const endTime = performance.now();
logger.performance('operationName', endTime - startTime);
```

## Integration in Bookmark Manager

The logger service has been integrated throughout the Bookmark Manager application:

### Key Areas Logged

1. **Application Initialization**
   - App startup
   - Data loading
   - Event listener setup

2. **User Interactions**
   - Button clicks
   - Form submissions
   - Keyboard shortcuts
   - Navigation actions

3. **Data Operations**
   - Bookmark creation/deletion/updates
   - Collection management
   - Search operations
   - Filtering

4. **API Operations**
   - Data loading from server
   - Data saving to server
   - Error handling

5. **Performance Metrics**
   - Rendering times
   - Function execution times
   - Data processing times

## Switching to Production

To deploy to production:

1. Edit `config.js`:
   ```javascript
   const CONFIG = {
       ENVIRONMENT: 'live', // Change from 'dev' to 'live'
       LOG_LEVEL: 'error',  // Only show errors in production
       // ... other settings
   };
   ```

2. All logging will be automatically disabled except for errors (if log level is set to 'error' or higher).

## Benefits

- **Development**: Comprehensive logging for debugging and development
- **Production**: Clean console with no performance impact
- **Debugging**: Easy to track user actions and data flow
- **Performance**: Monitor application performance
- **Maintenance**: Better understanding of application behavior

## Console Output Example

When in development mode, you'll see colored logs like:

```
[2024-01-15T10:30:45.123Z] [INFO] BookmarkManager initialized
[2024-01-15T10:30:45.124Z] [INFO] Entering function: loadData
[2024-01-15T10:30:45.125Z] [INFO] API Call: GET save-bookmarks.php
[2024-01-15T10:30:45.200Z] [INFO] API Response: GET save-bookmarks.php - 200
[2024-01-15T10:30:45.201Z] [SUCCESS] Data loaded successfully
[2024-01-15T10:30:45.202Z] [INFO] User Action: Add bookmark button clicked
[2024-01-15T10:30:45.203Z] [INFO] Entering function: showModal
[2024-01-15T10:30:45.204Z] [INFO] Exiting function: showModal
```

## Troubleshooting

### No logs appearing?
- Check that `ENVIRONMENT` is set to 'dev' in `config.js`
- Verify that `LOG_LEVEL` is set appropriately
- Ensure `logger.js` is loaded before `script.js`

### Too many logs?
- Increase the `LOG_LEVEL` in `config.js`
- Use `logger.setLogLevel('warn')` to only show warnings and errors

### Performance issues?
- Set `ENVIRONMENT` to 'live' to disable all logging
- Use `logger.setLogLevel('error')` to only show errors 