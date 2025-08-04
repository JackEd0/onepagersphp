// Bookmark Manager Application
class BookmarkManager {
    constructor() {
        this.bookmarks = [];
        this.collections = [];
        this.currentFilter = 'all';
        this.searchQuery = '';
        this.dataFile = 'bookmarks-data.json';
        
        this.loadData();
        this.initializeEventListeners();
        this.renderBookmarks();
        this.renderCollections();
        this.updateBookmarkCount();
        this.checkEmptyState();
    }

    async loadData() {
        try {
            const response = await fetch('save-bookmarks.php');
            if (response.ok) {
                const data = await response.json();
                this.bookmarks = data.bookmarks || [];
                this.collections = data.collections || [];
            } else {
                // If file doesn't exist, start with empty data
                this.bookmarks = [];
                this.collections = [];
            }
        } catch (error) {
            console.log('No existing data file found, starting fresh');
            this.bookmarks = [];
            this.collections = [];
        }
    }

    async saveData() {
        const data = {
            bookmarks: this.bookmarks,
            collections: this.collections,
            lastUpdated: new Date().toISOString()
        };

        try {
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
        } catch (error) {
            console.error('Error saving data:', error);
            // Fallback to localStorage if server save fails
            localStorage.setItem('bookmarks', JSON.stringify(this.bookmarks));
            localStorage.setItem('collections', JSON.stringify(this.collections));
        }
    }

    initializeEventListeners() {
        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                this.setActiveNav(link);
                this.currentFilter = link.dataset.filter;
                this.renderBookmarks();
                this.closeMobileMenu();
            });
        });

        // Search
        document.getElementById('searchInput').addEventListener('input', (e) => {
            this.searchQuery = e.target.value.toLowerCase();
            this.renderBookmarks();
        });

        // Add bookmark button
        document.getElementById('addBookmarkBtn').addEventListener('click', () => {
            this.showModal('addBookmarkModal');
        });

        // Empty state add button
        document.getElementById('emptyStateAddBtn').addEventListener('click', () => {
            this.showModal('addBookmarkModal');
        });

        // Add collection buttons
        document.getElementById('addCollectionBtn').addEventListener('click', () => {
            this.showModal('addCollectionModal');
        });

        document.getElementById('mobileAddCollectionBtn').addEventListener('click', () => {
            this.showModal('addCollectionModal');
        });

        // Mobile menu
        document.getElementById('mobileMenuBtn').addEventListener('click', () => {
            this.openMobileMenu();
        });

        document.getElementById('closeMobileMenu').addEventListener('click', () => {
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
            this.addBookmark();
        });

        document.getElementById('addCollectionForm').addEventListener('submit', (e) => {
            e.preventDefault();
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
                        this.showModal('addBookmarkModal');
                        break;
                    case 'k':
                        e.preventDefault();
                        document.getElementById('searchInput').focus();
                        break;
                }
            }
            if (e.key === 'Escape') {
                this.hideAllModals();
                this.closeMobileMenu();
            }
        });
    }

    openMobileMenu() {
        document.getElementById('mobileSidebar').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    closeMobileMenu() {
        document.getElementById('mobileSidebar').classList.add('hidden');
        document.body.style.overflow = '';
    }

    setActiveNav(activeLink) {
        // Update desktop navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('bg-blue-50', 'text-blue-700');
            link.classList.add('text-gray-700');
        });
        activeLink.classList.remove('text-gray-700');
        activeLink.classList.add('bg-blue-50', 'text-blue-700');

        // Update mobile navigation
        document.querySelectorAll('#mobileSidebar .nav-link').forEach(link => {
            link.classList.remove('bg-blue-50', 'text-blue-700');
            link.classList.add('text-gray-700');
        });
        const mobileLink = document.querySelector(`#mobileSidebar .nav-link[data-filter="${activeLink.dataset.filter}"]`);
        if (mobileLink) {
            mobileLink.classList.remove('text-gray-700');
            mobileLink.classList.add('bg-blue-50', 'text-blue-700');
        }
    }

    showModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        this.updateCollectionSelect();
    }

    hideModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = '';
        this.resetForm(modalId);
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
        const title = document.getElementById('bookmarkTitle').value.trim();
        const url = document.getElementById('bookmarkUrl').value.trim();
        const description = document.getElementById('bookmarkDescription').value.trim();
        const collectionId = document.getElementById('bookmarkCollection').value;
        const tags = document.getElementById('bookmarkTags').value.trim();

        if (!title || !url) {
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

        this.bookmarks.unshift(bookmark);
        await this.saveData();
        this.renderBookmarks();
        this.hideModal('addBookmarkModal');
        this.updateBookmarkCount();
        this.checkEmptyState();
    }

    async addCollection() {
        const name = document.getElementById('collectionName').value.trim();
        const description = document.getElementById('collectionDescription').value.trim();

        if (!name) {
            alert('Please enter a collection name.');
            return;
        }

        const collection = {
            id: Date.now().toString(),
            name,
            description,
            createdAt: new Date().toISOString()
        };

        this.collections.push(collection);
        await this.saveData();
        this.renderCollections();
        this.hideModal('addCollectionModal');
    }

    async deleteBookmark(id) {
        if (confirm('Are you sure you want to delete this bookmark?')) {
            this.bookmarks = this.bookmarks.filter(bookmark => bookmark.id !== id);
            await this.saveData();
            this.renderBookmarks();
            this.updateBookmarkCount();
            this.checkEmptyState();
        }
    }

    async toggleFavorite(id) {
        const bookmark = this.bookmarks.find(b => b.id === id);
        if (bookmark) {
            bookmark.favorite = !bookmark.favorite;
            bookmark.updatedAt = new Date().toISOString();
            await this.saveData();
            this.renderBookmarks();
        }
    }

    getFilteredBookmarks() {
        let filtered = this.bookmarks;

        // Apply search filter
        if (this.searchQuery) {
            filtered = filtered.filter(bookmark => 
                bookmark.title.toLowerCase().includes(this.searchQuery) ||
                bookmark.url.toLowerCase().includes(this.searchQuery) ||
                bookmark.description.toLowerCase().includes(this.searchQuery) ||
                bookmark.tags.some(tag => tag.toLowerCase().includes(this.searchQuery))
            );
        }

        // Apply navigation filter
        switch (this.currentFilter) {
            case 'favorites':
                filtered = filtered.filter(bookmark => bookmark.favorite);
                break;
            case 'recent':
                filtered = filtered.slice(0, 20); // Show last 20 bookmarks
                break;
            case 'collection':
                filtered = filtered.filter(bookmark => bookmark.collectionId === this.currentCollectionId);
                break;
            default:
                // 'all' - no additional filtering
                break;
        }

        return filtered;
    }

    renderBookmarks() {
        const bookmarksGrid = document.getElementById('bookmarksGrid');
        const filteredBookmarks = this.getFilteredBookmarks();

        if (filteredBookmarks.length === 0) {
            bookmarksGrid.innerHTML = '';
            return;
        }

        bookmarksGrid.innerHTML = filteredBookmarks.map(bookmark => {
            const collection = this.collections.find(c => c.id === bookmark.collectionId);
            const tagsHtml = bookmark.tags.map(tag => `<span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-lg mr-2 mb-2">${this.escapeHtml(tag)}</span>`).join('');
            const date = new Date(bookmark.createdAt).toLocaleDateString();
            
            return `
                <div class="bookmark-card bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-200 ${bookmark.favorite ? 'ring-2 ring-yellow-200' : ''}" data-id="${bookmark.id}">
                    <div class="bookmark-header flex items-start justify-between mb-4">
                        <div class="bookmark-title flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2 mb-2">${this.escapeHtml(bookmark.title)}</h3>
                        </div>
                        <div class="bookmark-actions flex gap-2 ml-4">
                            <button class="action-btn p-2 text-gray-400 hover:text-yellow-500 transition-colors duration-200 ${bookmark.favorite ? 'text-yellow-500' : ''}" 
                                    onclick="bookmarkManager.toggleFavorite('${bookmark.id}')" 
                                    title="${bookmark.favorite ? 'Remove from favorites' : 'Add to favorites'}">
                                <i class="fas fa-star"></i>
                            </button>
                            <button class="action-btn p-2 text-gray-400 hover:text-red-500 transition-colors duration-200" onclick="bookmarkManager.deleteBookmark('${bookmark.id}')" title="Delete bookmark">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="bookmark-url text-blue-600 hover:text-blue-800 cursor-pointer mb-3 text-sm truncate" onclick="window.open('${this.escapeHtml(bookmark.url)}', '_blank')" title="${this.escapeHtml(bookmark.url)}">
                        ${this.escapeHtml(bookmark.url)}
                    </div>
                    ${bookmark.description ? `<div class="bookmark-description text-gray-600 text-sm mb-4 line-clamp-3">${this.escapeHtml(bookmark.description)}</div>` : ''}
                    <div class="bookmark-meta">
                        <div class="bookmark-tags mb-3">
                            ${tagsHtml}
                            ${collection ? `<span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-lg mr-2 mb-2">${this.escapeHtml(collection.name)}</span>` : ''}
                        </div>
                        <div class="bookmark-date text-xs text-gray-500">${date}</div>
                    </div>
                </div>
            `;
        }).join('');
    }

    renderCollections() {
        const collectionsList = document.getElementById('collectionsList');
        const mobileCollectionsList = document.getElementById('mobileCollectionsList');
        
        const renderList = (listElement) => {
            if (this.collections.length === 0) {
                listElement.innerHTML = '<li class="text-gray-500 text-sm px-4 py-2">No collections yet</li>';
                return;
            }

            listElement.innerHTML = this.collections.map(collection => `
                <li class="collection-item" data-id="${collection.id}">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-folder w-5 text-gray-400"></i>
                        <span class="font-medium">${this.escapeHtml(collection.name)}</span>
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
        this.currentFilter = 'collection';
        this.currentCollectionId = collectionId;
        
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
    }

    updateBookmarkCount() {
        const count = this.getFilteredBookmarks().length;
        const totalCount = this.bookmarks.length;
        document.getElementById('bookmarkCount').textContent = `${count} bookmark${count !== 1 ? 's' : ''}${count !== totalCount ? ` of ${totalCount}` : ''}`;
    }

    checkEmptyState() {
        const emptyState = document.getElementById('emptyState');
        const bookmarksGrid = document.getElementById('bookmarksGrid');
        
        if (this.bookmarks.length === 0) {
            emptyState.classList.remove('hidden');
            bookmarksGrid.style.display = 'none';
        } else {
            emptyState.classList.add('hidden');
            bookmarksGrid.style.display = 'grid';
        }
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Add some sample data for demonstration
    async addSampleData() {
        if (this.bookmarks.length === 0) {
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
                }
            ];

            this.bookmarks = sampleBookmarks;
            this.collections = sampleCollections;
            await this.saveData();
            this.renderBookmarks();
            this.renderCollections();
            this.updateBookmarkCount();
            this.checkEmptyState();
        }
    }
}

// Initialize the application
const bookmarkManager = new BookmarkManager();

// Add sample data on first load (optional - remove this line if you don't want sample data)
bookmarkManager.addSampleData();

// Add some helpful keyboard shortcuts info
console.log('Keyboard shortcuts:');
console.log('Ctrl/Cmd + N: Add new bookmark');
console.log('Ctrl/Cmd + K: Focus search');
console.log('Escape: Close modals'); 