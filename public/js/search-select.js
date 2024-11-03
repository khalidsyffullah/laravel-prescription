// public/js/search-select.js
function initializeSearchSelect(config) {
    const {
        searchInputId,
        suggestionsId,
        selectedListId,
        searchRoute,
        storeRoute,
        csrfToken
    } = config;

    const searchInput = document.getElementById(searchInputId);
    const suggestions = document.getElementById(suggestionsId);
    const selectedList = document.getElementById(selectedListId);

    function updateSuggestions(keyword) {
        fetch(`${searchRoute}?keyword=${encodeURIComponent(keyword)}`)
            .then(response => response.json())
            .then(data => {
                suggestions.innerHTML = '';
                const selectedNames = Array.from(selectedList.children).map(div =>
                    div.textContent.trim().replace(" Remove", "")
                );

                let hasSuggestions = false;

                data.forEach(item => {
                    if (!selectedNames.includes(item.name)) {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        suggestions.appendChild(option);
                        hasSuggestions = true;
                    }
                });

                if (!hasSuggestions) {
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = "No matches found";
                    suggestions.appendChild(option);
                }
            });
    }

    function addToSelectedList(id, name) {
        const div = document.createElement('div');
        div.dataset.id = id;
        div.innerHTML = `${name} <button class="remove">Remove</button>`;
        selectedList.appendChild(div);

        // Remove from suggestions if exists
        const option = suggestions.querySelector(`option[value="${id}"]`);
        if (option) option.remove();
    }

    function findExactMatchInSuggestions(name) {
        return Array.from(suggestions.options).find(option =>
            option.textContent.toLowerCase() === name.toLowerCase()
        );
    }

    searchInput.addEventListener('input', function() {
        const keyword = this.value;
        if (keyword.length >= 3) {
            updateSuggestions(keyword);
        } else {
            suggestions.innerHTML = '';
        }
    });

    suggestions.addEventListener('change', function() {
        Array.from(this.selectedOptions).forEach(option => {
            if (option.textContent) {
                addToSelectedList(option.value, option.textContent);
            }
        });
        searchInput.value = '';
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const name = this.value.trim();
            const existsInSelected = Array.from(selectedList.children)
                .some(div => div.textContent.trim().replace(" Remove", "")
                    .toLowerCase() === name.toLowerCase());

            if (existsInSelected) {
                alert('This item is already selected.');
                return;
            }

            const exactMatch = findExactMatchInSuggestions(name);
            if (exactMatch) {
                addToSelectedList(exactMatch.value, exactMatch.textContent);
                this.value = '';
                suggestions.innerHTML = '';
            } else {
                // Create new item
                fetch(storeRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        name: name,
                        descriptions: ""
                    })
                })
                .then(response => response.json())
                .then(data => {
                    addToSelectedList(data.id, data.name);
                    searchInput.value = '';
                    suggestions.innerHTML = '';
                });
            }
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove')) {
            const parent = e.target.parentElement;
            const nameToRemove = parent.textContent.trim().replace(" Remove", "");
            const idToRemove = parent.dataset.id;

            const option = document.createElement('option');
            option.value = idToRemove;
            option.textContent = nameToRemove;
            suggestions.appendChild(option);

            parent.remove();
        }
    });
}
