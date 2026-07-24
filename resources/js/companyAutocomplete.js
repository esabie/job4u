document.addEventListener('alpine:init', () => {
    Alpine.data('companyAutocomplete', (endpoint, initialValue = '') => ({
        query: initialValue,
        suggestions: [],
        open: false,
        highlighted: -1,
        endpoint,

        async search() {
            const term = this.query.trim();

            if (term.length < 2) {
                this.suggestions = [];
                this.open = false;
                return;
            }

            try {
                const response = await fetch(
                    `${endpoint}?q=${encodeURIComponent(term)}`,
                    {
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    },
                );

                if (!response.ok) {
                    this.suggestions = [];
                    this.open = false;
                    return;
                }

                this.suggestions = await response.json();
                this.open = this.suggestions.length > 0;
                this.highlighted = -1;
            } catch {
                this.suggestions = [];
                this.open = false;
            }
        },

        select(suggestion) {
            this.query = suggestion.name;
            this.open = false;
            this.highlighted = -1;
        },

        highlightNext() {
            if (!this.open || this.suggestions.length === 0) {
                return;
            }

            this.highlighted = (this.highlighted + 1) % this.suggestions.length;
        },

        highlightPrevious() {
            if (!this.open || this.suggestions.length === 0) {
                return;
            }

            this.highlighted = this.highlighted <= 0
                ? this.suggestions.length - 1
                : this.highlighted - 1;
        },

        selectHighlighted() {
            if (this.highlighted >= 0 && this.suggestions[this.highlighted]) {
                this.select(this.suggestions[this.highlighted]);
            }
        },

        close() {
            this.open = false;
            this.highlighted = -1;
        },
    }));
});
