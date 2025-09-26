class LocationAutocomplete {
    constructor(inputSelector, suggestionsSelector, options = {}) {
        this.input = $(inputSelector);
        this.suggestions = $(suggestionsSelector);
        this.options = {
            minLength: 0,
            showAllOnFocus: true,
            onSelect: null,
            ...options
        };
        this.currentIndex = -1;
        this.locations = window.allLocations || [];
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        // Show suggestions on focus
        this.input.on('focus', () => {
            if (this.options.showAllOnFocus && !this.input.val().trim()) {
                this.showAllSuggestions();
            } else {
                this.filterSuggestions(this.input.val());
            }
        });

        // Filter as user types
        this.input.on('input', () => {
            const query = this.input.val();
            this.filterSuggestions(query);
            this.currentIndex = -1;
        });

        // Handle keyboard navigation
        this.input.on('keydown', (e) => {
            const items = this.suggestions.find('.suggestion-item');
            
            switch(e.keyCode) {
                case 38: // Up arrow
                    e.preventDefault();
                    this.currentIndex = this.currentIndex > 0 ? this.currentIndex - 1 : items.length - 1;
                    this.updateActiveItem(items);
                    break;
                case 40: // Down arrow
                    e.preventDefault();
                    this.currentIndex = this.currentIndex < items.length - 1 ? this.currentIndex + 1 : 0;
                    this.updateActiveItem(items);
                    break;
                case 13: // Enter
                    e.preventDefault();
                    if (this.currentIndex >= 0) {
                        this.selectItem(items.eq(this.currentIndex));
                    }
                    break;
                case 27: // Escape
                    this.hideSuggestions();
                    break;
            }
        });

        // Handle click on suggestions
        this.suggestions.on('click', '.suggestion-item', (e) => {
            this.selectItem($(e.target));
        });

        // Hide suggestions when clicking outside
        $(document).on('click', (e) => {
            if (!this.input.is(e.target) && 
                !this.suggestions.is(e.target) && 
                this.suggestions.has(e.target).length === 0) {
                this.hideSuggestions();
            }
        });
    }

    showAllSuggestions() {
        this.renderSuggestions(this.locations);
    }

    filterSuggestions(query) {
        if (!query || query.length < this.options.minLength) {
            if (this.options.showAllOnFocus) {
                this.showAllSuggestions();
            } else {
                this.hideSuggestions();
            }
            return;
        }

        const filtered = this.locations.filter(location => 
            location.name.toLowerCase().includes(query.toLowerCase())
        ).sort((a, b) => {
            const aStarts = a.name.toLowerCase().startsWith(query.toLowerCase());
            const bStarts = b.name.toLowerCase().startsWith(query.toLowerCase());
            
            if (aStarts && !bStarts) return -1;
            if (!aStarts && bStarts) return 1;
            
            // Secondary sort by relevance (how early the match appears)
            const aIndex = a.name.toLowerCase().indexOf(query.toLowerCase());
            const bIndex = b.name.toLowerCase().indexOf(query.toLowerCase());
            if (aIndex !== bIndex) return aIndex - bIndex;
            
            return a.name.localeCompare(b.name);
        });

        this.renderSuggestions(filtered.slice(0, 10)); // Limit to 10 results
    }

    renderSuggestions(locations) {
        if (locations.length === 0) {
            this.hideSuggestions();
            return;
        }

        const html = locations.map((location, index) => {
            const query = this.input.val().toLowerCase();
            let displayName = location.name;
            
            // Highlight matching text
            if (query) {
                const regex = new RegExp(`(${this.escapeRegex(query)})`, 'gi');
                displayName = location.name.replace(regex, '<strong>$1</strong>');
            }
            
            return `<div class="suggestion-item" data-index="${index}" data-name="${location.name}" data-slug="${location.slug}">${displayName}</div>`;
        }).join('');

        this.suggestions.html(html).show();
    }

    updateActiveItem(items) {
        items.removeClass('active');
        if (this.currentIndex >= 0 && this.currentIndex < items.length) {
            items.eq(this.currentIndex).addClass('active');
            // Scroll into view if necessary
            this.scrollToActiveItem();
        }
    }

    scrollToActiveItem() {
        const activeItem = this.suggestions.find('.suggestion-item.active');
        if (activeItem.length) {
            const container = this.suggestions;
            const itemTop = activeItem.position().top;
            const itemHeight = activeItem.outerHeight();
            const containerHeight = container.height();
            const scrollTop = container.scrollTop();

            if (itemTop < 0) {
                container.scrollTop(scrollTop + itemTop);
            } else if (itemTop + itemHeight > containerHeight) {
                container.scrollTop(scrollTop + itemTop + itemHeight - containerHeight);
            }
        }
    }

    selectItem(item) {
        const name = item.data('name');
        const slug = item.data('slug');
        
        this.input.val(name);
        this.input.data('selected-slug', slug);
        this.input.data('selected-name', name);
        this.hideSuggestions();
        
        if (this.options.onSelect) {
            this.options.onSelect(name, slug);
        }
        
        // Trigger change event
        this.input.trigger('change');
    }

    hideSuggestions() {
        this.suggestions.hide();
        this.currentIndex = -1;
    }

    escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // Public methods
    setValue(value) {
        this.input.val(value);
    }

    getValue() {
        return this.input.val();
    }

    getSelectedData() {
        return {
            name: this.input.data('selected-name'),
            slug: this.input.data('selected-slug')
        };
    }

    clear() {
        this.input.val('');
        this.input.removeData('selected-slug selected-name');
        this.hideSuggestions();
    }
}