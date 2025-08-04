// Bookmark Manager Application
class BookmarkManager {
    constructor() {
        this.bookmarks = [];
        this.collections = [];
        this.currentFilter = 'all';
        this.searchQuery = '';
        this.dataFile = 'bookmarks-data.json';
        
        logger.info('BookmarkManager initialized');
        
        this.loadData();
        this.initializeEventListeners();
        this.renderBookmarks();
        this.renderCollections();
        this.updateBookmarkCount();
        this.checkEmptyState();
    }

    async loadData() {
        logger.functionEntry('loadData');
        
        try {
            logger.apiCall('GET', 'save-bookmarks.php');
            const response = await fetch('save-bookmarks.php');
            
            if (response.ok) {
                const data = await response.json();
                this.bookmarks = data.bookmarks || [];
                this.collections = data.collections || [];
                logger.apiResponse('GET', 'save-bookmarks.php', response.status, { bookmarksCount: this.bookmarks.length, collectionsCount: this.collections.length });
                logger.success('Data loaded successfully');
            } else {
                // If file doesn't exist, start with empty data
                this.bookmarks = [];
                this.collections = [];
                logger.warn('No existing data file found, starting with empty data');
            }
        } catch (error) {
            logger.error('Error loading data', error);
            this.bookmarks = [];
            this.collections = [];
        }
        
        logger.functionExit('loadData', { bookmarksCount: this.bookmarks.length, collectionsCount: this.collections.length });
    }

    async saveData() {
        logger.functionEntry('saveData', { bookmarksCount: this.bookmarks.length, collectionsCount: this.collections.length });
        
        const data = {
            bookmarks: this.bookmarks,
            collections: this.collections,
            lastUpdated: new Date().toISOString()
        };

        try {
            logger.apiCall('POST', 'save-bookmarks.php', { dataSize: JSON.stringify(data).length });
            const response = await fetch('save-bookmarks.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error('Failed to save data');
            }
            
            logger.apiResponse('POST', 'save-bookmarks.php', response.status);
            logger.success('Data saved successfully');
        } catch (error) {
            logger.error('Error saving data', error);
            // Fallback to localStorage if server save fails
            localStorage.setItem('bookmarks', JSON.stringify(this.bookmarks));
            localStorage.setItem('collections', JSON.stringify(this.collections));
            logger.warn('Fallback to localStorage due to server save failure');
        }
        
        logger.functionExit('saveData');
    }

    initializeEventListeners() {
        logger.functionEntry('initializeEventListeners');
        
        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                logger.userAction('Navigation clicked', { filter: link.dataset.filter });
                this.setActiveNav(link);
                this.currentFilter = link.dataset.filter;
                this.renderBookmarks();
                this.closeMobileMenu();
            });
        });

        // Search
        document.getElementById('searchInput').addEventListener('input', (e) => {
            this.searchQuery = e.target.value.toLowerCase();
            logger.userAction('Search performed', { query: this.searchQuery });
            this.renderBookmarks();
        });

        // Add bookmark button
        document.getElementById('addBookmarkBtn').addEventListener('click', () => {
            logger.userAction('Add bookmark button clicked');
            this.showModal('addBookmarkModal');
        });

        // Empty state add button
        document.getElementById('emptyStateAddBtn').addEventListener('click', () => {
            logger.userAction('Empty state add button clicked');
            this.showModal('addBookmarkModal');
        });

        // Add collection buttons
        document.getElementById('addCollectionBtn').addEventListener('click', () => {
            logger.userAction('Add collection button clicked');
            this.showModal('addCollectionModal');
        });

        document.getElementById('mobileAddCollectionBtn').addEventListener('click', () => {
            logger.userAction('Mobile add collection button clicked');
            this.showModal('addCollectionModal');
        });

        // Mobile menu
        document.getElementById('mobileMenuBtn').addEventListener('click', () => {
            logger.userAction('Mobile menu opened');
            this.openMobileMenu();
        });

        document.getElementById('closeMobileMenu').addEventListener('click', () => {
            logger.userAction('Mobile menu closed');
            this.closeMobileMenu();
        });

        // Modal close buttons
        document.getElementById('closeBookmarkModal').addEventListener('click', () => {
            this.hideModal('addBookmarkModal');
        });

        document.getElementById('closeCollectionModal').addEventListener('click', () => {
            this.hideModal('addCollectionModal');
        });

        // Cancel buttons
        document.getElementById('cancelBookmarkBtn').addEventListener('click', () => {
            this.hideModal('addBookmarkModal');
        });

        document.getElementById('cancelCollectionBtn').addEventListener('click', () => {
            this.hideModal('addCollectionModal');
        });

        // Forms
        document.getElementById('addBookmarkForm').addEventListener('submit', (e) => {
            e.preventDefault();
            logger.userAction('Add bookmark form submitted');
            this.addBookmark();
        });

        document.getElementById('addCollectionForm').addEventListener('submit', (e) => {
            e.preventDefault();
            logger.userAction('Add collection form submitted');
            this.addCollection();
        });

        // Modal backdrop click
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.hideModal(modal.id);
                }
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case 'n':
                        e.preventDefault();
                        logger.userAction('Keyboard shortcut: Ctrl/Cmd + N (Add bookmark)');
                        this.showModal('addBookmarkModal');
                        break;
                    case 'k':
                        e.preventDefault();
                        logger.userAction('Keyboard shortcut: Ctrl/Cmd + K (Focus search)');
                        document.getElementById('searchInput').focus();
                        break;
                }
            }
            if (e.key === 'Escape') {
                logger.userAction('Keyboard shortcut: Escape (Close modals)');
                this.hideAllModals();
                this.closeMobileMenu();
            }
        });
    }

    openMobileMenu() {
        logger.functionEntry('openMobileMenu');
        document.getElementById('mobileSidebar').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        logger.functionExit('openMobileMenu');
    }

    closeMobileMenu() {
        logger.functionEntry('closeMobileMenu');
        document.getElementById('mobileSidebar').classList.add('hidden');
        document.body.style.overflow = '';
        logger.functionExit('closeMobileMenu');
    }

    setActiveNav(activeLink) {
        // Update desktop navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('bg-blue-600/10', 'text-blue-400');
            link.classList.add('text-dark-300');
        });
        activeLink.classList.remove('text-dark-300');
        activeLink.classList.add('bg-blue-600/10', 'text-blue-400');

        // Update mobile navigation
        document.querySelectorAll('#mobileSidebar .nav-link').forEach(link => {
            link.classList.remove('bg-blue-600/10', 'text-blue-400');
            link.classList.add('text-dark-300');
        });
        const mobileLink = document.querySelector(`#mobileSidebar .nav-link[data-filter="${activeLink.dataset.filter}"]`);
        if (mobileLink) {
            mobileLink.classList.remove('text-dark-300');
            mobileLink.classList.add('bg-blue-600/10', 'text-blue-400');
        }
    }

    showModal(modalId) {
        logger.functionEntry('showModal', { modalId });
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        this.updateCollectionSelect();
        logger.functionExit('showModal');
    }

    hideModal(modalId) {
        logger.functionEntry('hideModal', { modalId });
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = '';
        this.resetForm(modalId);
        logger.functionExit('hideModal');
    }

    hideAllModals() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.classList.add('hidden');
        });
        document.body.style.overflow = '';
    }

    resetForm(modalId) {
        const form = document.querySelector(`#${modalId} form`);
        if (form) {
            form.reset();
        }
    }

    updateCollectionSelect() {
        const select = document.getElementById('bookmarkCollection');
        select.innerHTML = '<option value="">No collection</option>';
        
        this.collections.forEach(collection => {
            const option = document.createElement('option');
            option.value = collection.id;
            option.textContent = collection.name;
            select.appendChild(option);
        });
    }

    async addBookmark() {
        logger.functionEntry('addBookmark');
        
        const title = document.getElementById('bookmarkTitle').value.trim();
        const url = document.getElementById('bookmarkUrl').value.trim();
        const description = document.getElementById('bookmarkDescription').value.trim();
        const collectionId = document.getElementById('bookmarkCollection').value;
        const tags = document.getElementById('bookmarkTags').value.trim();

        logger.debug('Bookmark form data', { title, url, description, collectionId, tags });

        if (!title || !url) {
            logger.warn('Add bookmark validation failed', { title: !!title, url: !!url });
            alert('Please fill in the title and URL fields.');
            return;
        }

        const bookmark = {
            id: Date.now().toString(),
            title,
            url,
            description,
            collectionId: collectionId || null,
            tags: tags ? tags.split(',').map(tag => tag.trim()).filter(tag => tag) : [],
            favorite: false,
            createdAt: new Date().toISOString(),
            updatedAt: new Date().toISOString()
        };

        logger.dataOperation('create', 'bookmark', bookmark);
        this.bookmarks.unshift(bookmark);
        await this.saveData();
        this.renderBookmarks();
        this.hideModal('addBookmarkModal');
        this.updateBookmarkCount();
        this.checkEmptyState();
        
        logger.success('Bookmark added successfully', { bookmarkId: bookmark.id });
        logger.functionExit('addBookmark', { bookmarkId: bookmark.id });
    }

    async addCollection() {
        logger.functionEntry('addCollection');
        
        const name = document.getElementById('collectionName').value.trim();
        const description = document.getElementById('collectionDescription').value.trim();

        logger.debug('Collection form data', { name, description });

        if (!name) {
            logger.warn('Add collection validation failed', { name: !!name });
            alert('Please enter a collection name.');
            return;
        }

        const collection = {
            id: Date.now().toString(),
            name,
            description,
            createdAt: new Date().toISOString()
        };

        logger.dataOperation('create', 'collection', collection);
        this.collections.push(collection);
        await this.saveData();
        this.renderCollections();
        this.hideModal('addCollectionModal');
        
        logger.success('Collection added successfully', { collectionId: collection.id });
        logger.functionExit('addCollection', { collectionId: collection.id });
    }

    async deleteBookmark(id) {
        logger.functionEntry('deleteBookmark', { bookmarkId: id });
        
        if (confirm('Are you sure you want to delete this bookmark?')) {
            logger.userAction('Bookmark deletion confirmed', { bookmarkId: id });
            this.bookmarks = this.bookmarks.filter(bookmark => bookmark.id !== id);
            logger.dataOperation('delete', 'bookmark', { bookmarkId: id });
            await this.saveData();
            this.renderBookmarks();
            this.updateBookmarkCount();
            this.checkEmptyState();
            logger.success('Bookmark deleted successfully', { bookmarkId: id });
        } else {
            logger.userAction('Bookmark deletion cancelled', { bookmarkId: id });
        }
        
        logger.functionExit('deleteBookmark');
    }

    async toggleFavorite(id) {
        logger.functionEntry('toggleFavorite', { bookmarkId: id });
        
        const bookmark = this.bookmarks.find(b => b.id === id);
        if (bookmark) {
            const wasFavorite = bookmark.favorite;
            bookmark.favorite = !bookmark.favorite;
            bookmark.updatedAt = new Date().toISOString();
            
            logger.userAction('Bookmark favorite toggled', { 
                bookmarkId: id, 
                wasFavorite, 
                isFavorite: bookmark.favorite 
            });
            
            logger.dataOperation('update', 'bookmark', { 
                bookmarkId: id, 
                field: 'favorite', 
                value: bookmark.favorite 
            });
            
            await this.saveData();
            this.renderBookmarks();
            logger.success('Bookmark favorite status updated', { bookmarkId: id, isFavorite: bookmark.favorite });
        } else {
            logger.warn('Bookmark not found for favorite toggle', { bookmarkId: id });
        }
        
        logger.functionExit('toggleFavorite');
    }

    getFilteredBookmarks() {
        logger.functionEntry('getFilteredBookmarks', { 
            searchQuery: this.searchQuery, 
            currentFilter: this.currentFilter 
        });
        
        let filtered = this.bookmarks;

        // Apply search filter
        if (this.searchQuery) {
            const beforeSearch = filtered.length;
            filtered = filtered.filter(bookmark => 
                bookmark.title.toLowerCase().includes(this.searchQuery) ||
                bookmark.url.toLowerCase().includes(this.searchQuery) ||
                bookmark.description.toLowerCase().includes(this.searchQuery) ||
                bookmark.tags.some(tag => tag.toLowerCase().includes(this.searchQuery))
            );
            logger.debug('Search filter applied', { 
                beforeSearch, 
                afterSearch: filtered.length, 
                query: this.searchQuery 
            });
        }

        // Apply navigation filter
        switch (this.currentFilter) {
            case 'favorites':
                const beforeFavorites = filtered.length;
                filtered = filtered.filter(bookmark => bookmark.favorite);
                logger.debug('Favorites filter applied', { 
                    beforeFavorites, 
                    afterFavorites: filtered.length 
                });
                break;
            case 'recent':
                const beforeRecent = filtered.length;
                filtered = filtered.slice(0, 20); // Show last 20 bookmarks
                logger.debug('Recent filter applied', { 
                    beforeRecent, 
                    afterRecent: filtered.length 
                });
                break;
            case 'collection':
                const beforeCollection = filtered.length;
                filtered = filtered.filter(bookmark => bookmark.collectionId === this.currentCollectionId);
                logger.debug('Collection filter applied', { 
                    beforeCollection, 
                    afterCollection: filtered.length, 
                    collectionId: this.currentCollectionId 
                });
                break;
            default:
                // 'all' - no additional filtering
                logger.debug('No additional filter applied (all bookmarks)');
                break;
        }

        logger.functionExit('getFilteredBookmarks', { resultCount: filtered.length });
        return filtered;
    }

    getDomainFromUrl(url) {
        try {
            const domain = new URL(url).hostname.replace('www.', '');
            return domain;
        } catch {
            return 'unknown';
        }
    }

    getThumbnailColor(url) {
        // Generate a consistent color based on the URL
        let hash = 0;
        for (let i = 0; i < url.length; i++) {
            const char = url.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash; // Convert to 32-bit integer
        }
        
        const colors = [
            'from-blue-500 to-blue-600',
            'from-purple-500 to-purple-600',
            'from-green-500 to-green-600',
            'from-red-500 to-red-600',
            'from-yellow-500 to-yellow-600',
            'from-pink-500 to-pink-600',
            'from-indigo-500 to-indigo-600',
            'from-teal-500 to-teal-600'
        ];
        
        return colors[Math.abs(hash) % colors.length];
    }

    formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffTime = Math.abs(now - date);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays === 1) {
            return 'Today';
        } else if (diffDays === 2) {
            return 'Yesterday';
        } else if (diffDays <= 7) {
            return `${diffDays - 1} days ago`;
        } else {
            return date.toLocaleDateString('en-US', { 
                month: 'short', 
                day: 'numeric',
                year: date.getFullYear() !== now.getFullYear() ? 'numeric' : undefined
            });
        }
    }

    renderBookmarks() {
        logger.functionEntry('renderBookmarks');
        
        const startTime = performance.now();
        const bookmarksGrid = document.getElementById('bookmarksGrid');
        const filteredBookmarks = this.getFilteredBookmarks();

        if (filteredBookmarks.length === 0) {
            bookmarksGrid.innerHTML = '';
            logger.debug('No bookmarks to render');
            return;
        }

        bookmarksGrid.innerHTML = filteredBookmarks.map(bookmark => {
            const collection = this.collections.find(c => c.id === bookmark.collectionId);
            const domain = this.getDomainFromUrl(bookmark.url);
            const thumbnailColor = this.getThumbnailColor(bookmark.url);
            const formattedDate = this.formatDate(bookmark.createdAt);
            
            const tagsHtml = bookmark.tags.map(tag => 
                `<span class="inline-block bg-dark-700 text-dark-300 text-xs px-2 py-1 rounded-md mr-2 mb-2">#${this.escapeHtml(tag)}</span>`
            ).join('');
            
            return `
                <div class="bookmark-card bg-dark-800 rounded-xl border border-dark-700 hover:border-dark-600 transition-all duration-200 overflow-hidden group ${bookmark.favorite ? 'ring-1 ring-yellow-500/30' : ''}" data-id="${bookmark.id}">
                    <!-- Thumbnail -->
                    <div class="bookmark-thumbnail h-32 bg-gradient-to-br ${thumbnailColor} relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-link text-white/80 text-2xl"></i>
                        </div>
                        <div class="absolute top-3 right-3 flex gap-1 z-10">
                            <button class="action-btn p-1.5 text-white/60 hover:text-white hover:bg-black/20 rounded transition-colors duration-200 ${bookmark.favorite ? 'text-yellow-400' : ''}" 
                                    onclick="event.stopPropagation(); bookmarkManager.toggleFavorite('${bookmark.id}')" 
                                    title="${bookmark.favorite ? 'Remove from favorites' : 'Add to favorites'}">
                                <i class="fas fa-star text-sm"></i>
                            </button>
                            <button class="action-btn p-1.5 text-white/60 hover:text-white hover:bg-black/20 rounded transition-colors duration-200" onclick="event.stopPropagation(); bookmarkManager.deleteBookmark('${bookmark.id}')" title="Delete bookmark">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-4">
                        <div class="bookmark-header mb-3">
                            <h3 class="text-white font-medium line-clamp-2 mb-2 text-sm leading-tight">${this.escapeHtml(bookmark.title)}</h3>
                            <div class="text-dark-400 text-xs mb-2">${this.escapeHtml(domain)}</div>
                        </div>
                        
                        ${bookmark.description ? `<div class="bookmark-description text-dark-300 text-xs mb-3 line-clamp-2">${this.escapeHtml(bookmark.description)}</div>` : ''}
                        
                        <div class="bookmark-meta">
                            <div class="bookmark-tags mb-3">
                                ${tagsHtml}
                                ${collection ? `<span class="inline-block bg-blue-600/20 text-blue-400 text-xs px-2 py-1 rounded-md mr-2 mb-2">${this.escapeHtml(collection.name)}</span>` : ''}
                            </div>
                            <div class="bookmark-date text-xs text-dark-400">${formattedDate}</div>
                        </div>
                    </div>
                    
                    <!-- Click overlay -->
                    <div class="absolute inset-0 cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-200" onclick="window.open('${this.escapeHtml(bookmark.url)}', '_blank')"></div>
                </div>
            `;
        }).join('');
        
        const endTime = performance.now();
        const renderTime = endTime - startTime;
        logger.performance('renderBookmarks', renderTime);
        logger.functionExit('renderBookmarks', { 
            bookmarksRendered: filteredBookmarks.length, 
            renderTime: `${renderTime.toFixed(2)}ms` 
        });
    }

    renderCollections() {
        const collectionsList = document.getElementById('collectionsList');
        const mobileCollectionsList = document.getElementById('mobileCollectionsList');
        
        const renderList = (listElement) => {
            if (this.collections.length === 0) {
                listElement.innerHTML = '<li class="text-dark-400 text-xs px-3 py-2">No collections yet</li>';
                return;
            }

            listElement.innerHTML = this.collections.map(collection => `
                <li class="collection-item" data-id="${collection.id}">
                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-dark-300 hover:text-white hover:bg-dark-800 transition-colors duration-200 text-sm">
                        <i class="fas fa-folder w-4 text-dark-400"></i>
                        <span class="font-medium">${this.escapeHtml(collection.name)}</span>
                        <span class="ml-auto text-xs text-dark-400">${this.bookmarks.filter(b => b.collectionId === collection.id).length}</span>
                    </a>
                </li>
            `).join('');

            // Add click event listeners to collection items
            listElement.querySelectorAll('.collection-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.filterByCollection(item.dataset.id);
                });
            });
        };

        renderList(collectionsList);
        renderList(mobileCollectionsList);
    }

    filterByCollection(collectionId) {
        logger.functionEntry('filterByCollection', { collectionId });
        
        this.currentFilter = 'collection';
        this.currentCollectionId = collectionId;
        
        logger.userAction('Collection filter applied', { collectionId });
        
        // Update navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.parentElement.classList.remove('active');
        });
        
        // Update collection selection
        document.querySelectorAll('.collection-item').forEach(item => {
            item.classList.remove('active');
        });
        document.querySelector(`[data-id="${collectionId}"]`).classList.add('active');
        
        this.renderBookmarks();
        this.closeMobileMenu();
        
        logger.functionExit('filterByCollection');
    }

    updateBookmarkCount() {
        logger.functionEntry('updateBookmarkCount');
        
        const count = this.getFilteredBookmarks().length;
        const totalCount = this.bookmarks.length;
        document.getElementById('bookmarkCount').textContent = `${count} bookmark${count !== 1 ? 's' : ''}${count !== totalCount ? ` of ${totalCount}` : ''}`;
        
        logger.debug('Bookmark count updated', { filteredCount: count, totalCount });
        logger.functionExit('updateBookmarkCount');
    }

    checkEmptyState() {
        logger.functionEntry('checkEmptyState');
        
        const emptyState = document.getElementById('emptyState');
        const bookmarksGrid = document.getElementById('bookmarksGrid');
        
        if (this.bookmarks.length === 0) {
            emptyState.classList.remove('hidden');
            bookmarksGrid.style.display = 'none';
            logger.debug('Empty state shown', { bookmarksCount: this.bookmarks.length });
        } else {
            emptyState.classList.add('hidden');
            bookmarksGrid.style.display = 'grid';
            logger.debug('Bookmarks grid shown', { bookmarksCount: this.bookmarks.length });
        }
        
        logger.functionExit('checkEmptyState');
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Add some sample data for demonstration
    async addSampleData() {
        logger.functionEntry('addSampleData');
        
        if (this.bookmarks.length === 0) {
            logger.info('Adding sample data for demonstration');
            const sampleBookmarks = [
                {
                    id: '1',
                    title: 'GitHub - The world\'s leading software development platform',
                    url: 'https://github.com',
                    description: 'GitHub is where over 100 million developers shape the future of software, together.',
                    collectionId: null,
                    tags: ['development', 'coding', 'git'],
                    favorite: true,
                    createdAt: new Date(Date.now() - 86400000).toISOString(),
                    updatedAt: new Date(Date.now() - 86400000).toISOString()
                },
                {
                    id: '2',
                    title: 'Stack Overflow - Where Developers Learn, Share, & Build Careers',
                    url: 'https://stackoverflow.com',
                    description: 'Stack Overflow is the largest, most trusted online community for developers to learn, share their programming knowledge.',
                    collectionId: null,
                    tags: ['programming', 'help', 'community'],
                    favorite: false,
                    createdAt: new Date(Date.now() - 172800000).toISOString(),
                    updatedAt: new Date(Date.now() - 172800000).toISOString()
                },
                {
                    id: '3',
                    title: 'MDN Web Docs - Learn web development',
                    url: 'https://developer.mozilla.org',
                    description: 'The MDN Web Docs site provides information about Open Web technologies including HTML, CSS, and APIs for both Web sites and progressive web apps.',
                    collectionId: null,
                    tags: ['documentation', 'web', 'learning'],
                    favorite: true,
                    createdAt: new Date(Date.now() - 259200000).toISOString(),
                    updatedAt: new Date(Date.now() - 259200000).toISOString()
                },
                {
                    id: '4',
                    title: 'How to Install and Dual Boot Linux on a Mac',
                    url: 'https://howtogeek.com/linux-mac-dual-boot',
                    description: 'Installing Windows on your Mac is easy with Boot Camp, but Boot Camp won\'t help you install Linux. You\'ll have to get creative.',
                    collectionId: null,
                    tags: ['macos', 'tutorial', 'linux'],
                    favorite: false,
                    createdAt: new Date(Date.now() - 345600000).toISOString(),
                    updatedAt: new Date(Date.now() - 345600000).toISOString()
                },
                {
                    id: '5',
                    title: 'MongoDB Hosting: Database-as-a-Service by mLab',
                    url: 'https://mlab.com',
                    description: 'mLab is the largest cloud MongoDB service, hosting over 900,000 deployments worldwide on AWS, Azure, and Google Cloud.',
                    collectionId: null,
                    tags: ['mongodb', 'database', 'cloud'],
                    favorite: true,
                    createdAt: new Date(Date.now() - 432000000).toISOString(),
                    updatedAt: new Date(Date.now() - 432000000).toISOString()
                },
                {
                    id: '6',
                    title: 'Upgrading New 2014/2015 Mac Mini to SSD (Solid State Drive)',
                    url: 'https://youtube.com/watch?v=mac-mini-ssd-upgrade',
                    description: 'Taking apart the new late 2014 Mac Mini to replace the hard drive. The HDD is still a removable SATA drive. Replaced with Samsung 850 EVO SSD.',
                    collectionId: null,
                    tags: ['macos', 'tutorial', 'hardware'],
                    favorite: false,
                    createdAt: new Date(Date.now() - 518400000).toISOString(),
                    updatedAt: new Date(Date.now() - 518400000).toISOString()
                }
            ];

            const sampleCollections = [
                {
                    id: '1',
                    name: 'Development',
                    description: 'Web development resources and tools',
                    createdAt: new Date().toISOString()
                },
                {
                    id: '2',
                    name: 'Design',
                    description: 'Design inspiration and resources',
                    createdAt: new Date().toISOString()
                },
                {
                    id: '3',
                    name: 'Tutorials',
                    description: 'Step-by-step guides and tutorials',
                    createdAt: new Date().toISOString()
                }
            ];

            this.bookmarks = sampleBookmarks;
            this.collections = sampleCollections;
            await this.saveData();
            this.renderBookmarks();
            this.renderCollections();
            this.updateBookmarkCount();
            this.checkEmptyState();
            
            logger.success('Sample data added successfully', { 
                bookmarksCount: sampleBookmarks.length, 
                collectionsCount: sampleCollections.length 
            });
        } else {
            logger.debug('Sample data already exists, skipping');
        }
        
        logger.functionExit('addSampleData');
    }
}

// Initialize the application
const bookmarkManager = new BookmarkManager();

// Add sample data on first load (optional - remove this line if you don't want sample data)
bookmarkManager.addSampleData();

// Log application startup
logger.info('Bookmark Manager application started successfully');
logger.info('Environment:', logger.ENVIRONMENT);

// Add some helpful keyboard shortcuts info
logger.info('Keyboard shortcuts available:');
logger.info('- Ctrl/Cmd + N: Add new bookmark');
logger.info('- Ctrl/Cmd + K: Focus search');
logger.info('- Escape: Close modals'); 