// Logger Service for Bookmark Manager
class Logger {
    constructor() {
        // Environment constant - use config if available, otherwise default to 'dev'
        this.ENVIRONMENT = (typeof CONFIG !== 'undefined' ? CONFIG.ENVIRONMENT : 'dev');
        
        // Log levels
        this.LEVELS = {
            DEBUG: 0,
            INFO: 1,
            WARN: 2,
            ERROR: 3
        };
        
        // Current log level - use config if available, otherwise default to INFO
        const configLogLevel = (typeof CONFIG !== 'undefined' ? CONFIG.LOG_LEVEL : 'info');
        this.setLogLevel(configLogLevel);
        
        // Log colors for console output
        this.colors = {
            debug: '#6B7280',
            info: '#3B82F6',
            warn: '#F59E0B',
            error: '#EF4444',
            success: '#10B981'
        };
    }

    /**
     * Check if logging is enabled based on environment
     * @returns {boolean}
     */
    isLoggingEnabled() {
        return this.ENVIRONMENT === 'dev';
    }

    /**
     * Format timestamp for logs
     * @returns {string}
     */
    getTimestamp() {
        return new Date().toISOString();
    }

    /**
     * Format log message with timestamp and level
     * @param {string} level - Log level
     * @param {string} message - Log message
     * @param {any} data - Additional data to log
     * @returns {string}
     */
    formatMessage(level, message, data = null) {
        const timestamp = this.getTimestamp();
        const prefix = `[${timestamp}] [${level.toUpperCase()}]`;
        
        if (data) {
            return `${prefix} ${message}`, data;
        }
        return `${prefix} ${message}`;
    }

    /**
     * Log debug message
     * @param {string} message - Debug message
     * @param {any} data - Additional data
     */
    debug(message, data = null) {
        if (!this.isLoggingEnabled() || this.LEVELS.DEBUG < this.currentLevel) return;
        
        const formattedMessage = this.formatMessage('debug', message, data);
        console.log(`%c${formattedMessage}`, `color: ${this.colors.debug}`, data || '');
    }

    /**
     * Log info message
     * @param {string} message - Info message
     * @param {any} data - Additional data
     */
    info(message, data = null) {
        if (!this.isLoggingEnabled() || this.LEVELS.INFO < this.currentLevel) return;
        
        const formattedMessage = this.formatMessage('info', message, data);
        console.log(`%c${formattedMessage}`, `color: ${this.colors.info}`, data || '');
    }

    /**
     * Log warning message
     * @param {string} message - Warning message
     * @param {any} data - Additional data
     */
    warn(message, data = null) {
        if (!this.isLoggingEnabled() || this.LEVELS.WARN < this.currentLevel) return;
        
        const formattedMessage = this.formatMessage('warn', message, data);
        console.warn(`%c${formattedMessage}`, `color: ${this.colors.warn}`, data || '');
    }

    /**
     * Log error message
     * @param {string} message - Error message
     * @param {any} data - Additional data
     */
    error(message, data = null) {
        if (!this.isLoggingEnabled() || this.LEVELS.ERROR < this.currentLevel) return;
        
        const formattedMessage = this.formatMessage('error', message, data);
        console.error(`%c${formattedMessage}`, `color: ${this.colors.error}`, data || '');
    }

    /**
     * Log success message
     * @param {string} message - Success message
     * @param {any} data - Additional data
     */
    success(message, data = null) {
        if (!this.isLoggingEnabled()) return;
        
        const formattedMessage = this.formatMessage('success', message, data);
        console.log(`%c${formattedMessage}`, `color: ${this.colors.success}`, data || '');
    }

    /**
     * Log function entry
     * @param {string} functionName - Name of the function
     * @param {any} params - Function parameters
     */
    functionEntry(functionName, params = null) {
        this.debug(`Entering function: ${functionName}`, params);
    }

    /**
     * Log function exit
     * @param {string} functionName - Name of the function
     * @param {any} result - Function result
     */
    functionExit(functionName, result = null) {
        this.debug(`Exiting function: ${functionName}`, result);
    }

    /**
     * Log API call
     * @param {string} method - HTTP method
     * @param {string} url - API URL
     * @param {any} data - Request data
     */
    apiCall(method, url, data = null) {
        this.info(`API Call: ${method.toUpperCase()} ${url}`, data);
    }

    /**
     * Log API response
     * @param {string} method - HTTP method
     * @param {string} url - API URL
     * @param {number} status - Response status
     * @param {any} data - Response data
     */
    apiResponse(method, url, status, data = null) {
        const level = status >= 400 ? 'error' : 'info';
        const message = `API Response: ${method.toUpperCase()} ${url} - ${status}`;
        
        if (level === 'error') {
            this.error(message, data);
        } else {
            this.info(message, data);
        }
    }

    /**
     * Log user action
     * @param {string} action - User action description
     * @param {any} data - Action data
     */
    userAction(action, data = null) {
        this.info(`User Action: ${action}`, data);
    }

    /**
     * Log data operation
     * @param {string} operation - Data operation (create, read, update, delete)
     * @param {string} entity - Entity type (bookmark, collection, etc.)
     * @param {any} data - Operation data
     */
    dataOperation(operation, entity, data = null) {
        this.info(`Data ${operation}: ${entity}`, data);
    }

    /**
     * Log performance metric
     * @param {string} metric - Metric name
     * @param {number} value - Metric value
     * @param {string} unit - Unit of measurement
     */
    performance(metric, value, unit = 'ms') {
        this.debug(`Performance: ${metric} = ${value}${unit}`);
    }

    /**
     * Set log level
     * @param {string} level - Log level ('debug', 'info', 'warn', 'error')
     */
    setLogLevel(level) {
        const levelKey = level.toUpperCase();
        if (this.LEVELS.hasOwnProperty(levelKey)) {
            this.currentLevel = this.LEVELS[levelKey];
            this.info(`Log level set to: ${level}`);
        } else {
            this.warn(`Invalid log level: ${level}`);
        }
    }

    /**
     * Set environment
     * @param {string} environment - Environment ('dev' or 'live')
     */
    setEnvironment(environment) {
        if (environment === 'dev' || environment === 'live') {
            this.ENVIRONMENT = environment;
            this.info(`Environment set to: ${environment}`);
        } else {
            this.warn(`Invalid environment: ${environment}`);
        }
    }
}

// Create global logger instance
const logger = new Logger();

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Logger;
} 