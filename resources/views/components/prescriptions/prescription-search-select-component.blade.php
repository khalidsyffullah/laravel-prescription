<div class="input-section">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <input type="text" class="{{ $itemInputField }}" id="{{ $itemInputField }}"
        placeholder="Type a {{ $itemName }} name and press Enter">

    <!-- Dynamic selection dropdown -->
    <select class="option-select" id="{{ $itemName }}-select" multiple>
    </select>
</div>

<div class="session-data" id="{{ $itemName }}-session-data">
    <!-- Display existing session data on page load -->
    @foreach ($selectedItems as $item)
        <div class="item" data-id="{{ $item['id'] }}">
            {{ $item['name'] }} (ID: {{ $item['id'] }})
            <span class="remove-btn" id= "{{ $itemName }}-remove-btn" data-id="{{ $item['id'] }}">Remove</span>
        </div>
    @endforeach
</div>


<script>
    function dataExistingCheckInSession(inputText) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ $checkItemInSessionRoute }}',
                method: 'POST',
                data: {
                    name: inputText
                },
                success: function(response) {
                    if (response.exists && response.{{ $selectItems }}) {
                        resolve(response.{{ $selectItems }});
                    } else {
                        resolve(null);
                    }
                },
                error: function(xhr) {
                    reject(xhr);
                    console.error("An error occurred while checking session data:", xhr
                        .responseText);
                }
            });
        });
    }
    $(document).ready(function() {
        debugger
        //CSRF token setup for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // Handle input field keyup event
        $('#{{ $itemInputField }}').on('keyup', function(e) {
            const inputText = $(this).val().trim().toLowerCase();

            // Only perform search if the input length is at least 3 characters
            if (inputText.length >= 3) {
                // Send search request to the server
                $.post('{{ $itemSearchRoute }}', {
                    keyword: inputText
                }, function(response) {
                    // Remove any already selected {{ $itemName }} from suggestions
                    const {{ $selectItems }}Ids = $(
                        '#{{ $itemName }}-session-data .item').map(function() {
                        return $(this).data('id');
                    }).get();
                    const filtered{{ $itemName }} = response.{{ $itemName }}.filter(
                        {{ $itemName }} =>
                        !{{ $selectItems }}Ids.includes({{ $itemName }}.id)
                    );

                    update{{ $itemName }}Suggestions(filtered{{ $itemName }},
                        inputText);
                });
            } else {
                // Clear the {{ $itemName }} suggestions dropdown
                $('#{{ $itemName }}-select').empty();
            }

            // Handle "Enter" key press on input field
            if (e.key === 'Enter') {
                debugger
                e.preventDefault(); // Prevent form submission

                const inputText = $('#{{ $itemInputField }}').val().trim().toLowerCase();

                // Check if the input text already exists in the session
                const existingItem = $('#{{ $itemName }}-session-data .item').filter(function() {
                    return $(this).text().toLowerCase().includes(inputText);
                });


                // Find matching option in the dropdown by name
                const matchingOption = $('#{{ $itemName }}-select option').filter(function() {
                    return $(this).text().toLowerCase() === inputText;
                });

                if (matchingOption.length > 0) {
                    const id = matchingOption.val();
                    const name = matchingOption.text();

                    // Send matched selection to server for storing in session
                    $.post('{{ $storeItemSelectionRoute }}', {
                        id: id,
                        name: name
                    }, function(response) {
                        updateSessionData(response.{{ $selectItems }});
                        // Clear the input field and the suggestions dropdown
                        $('#{{ $itemInputField }}').val('');
                        $('#{{ $itemName }}-select').empty();
                    });
                } else {
                    debugger
                    // If no match found, create a new {{ $itemName }}
                    $.post('{{ $itemStoreRoute }}', {
                        name: inputText
                    }, function(response) {
                        $.post('{{ $storeItemSelectionRoute }}', {
                            id: response.{{ $itemName }}.id,
                            name: response.{{ $itemName }}.name
                        }, function(response) {
                            updateSessionData(response.{{ $selectItems }});

                            // Clear the input field and the suggestions dropdown
                            $('#{{ $itemInputField }}').val('');
                            $('#{{ $itemName }}-select').empty();
                        });
                    });
                }

            }
        });

        // Handle selection change from dropdown
        $('#{{ $itemName }}-select').on('change', function() {
            $('#{{ $itemName }}-select option:selected').each(function() {
                const id = $(this).val();
                const name = $(this).text();

                // Send selection to server for storing in session
                $.post('{{ $storeItemSelectionRoute }}', {
                    id: id,
                    name: name
                }, (response) => {
                    updateSessionData(response.{{ $selectItems }});

                    // Remove the selected option from the dropdown
                    $(this).remove();
                });
            });
        });

        // Function to update session data display
        function updateSessionData({{ $selectItems }}) {
            $('#{{ $itemName }}-session-data').empty();

            // Display each selected {{ $itemName }}
            {{ $selectItems }}.forEach(function(item) {
                $('#{{ $itemName }}-session-data').append(
                    `<div class="item" data-id="${item.id}">
                ${item.name} (ID: ${item.id})
                <span class="remove-btn" id ="{{ $itemName }}-remove-btn" data-id="${item.id}">Remove</span>
            </div>`
                );
            });
        }

        // Function to update {{ $itemName }} suggestions dropdown
        async function update{{ $itemName }}Suggestions({{ $itemName }}, inputText) {
            try {
                // Get session data
                const sessionData = await dataExistingCheckInSession(inputText);

                // Initialize {{ $itemName }}Names array
                const {{ $itemName }}Names = [];

                // If we have session data, add it to {{ $itemName }}Names
                if (sessionData) {
                    if (Array.isArray(sessionData)) {
                        // If sessionData is an array
                        sessionData.forEach({{ $itemName }} => {
                            {{ $itemName }}Names.push({{ $itemName }}.name.toLowerCase());
                        });
                    } else {
                        // If sessionData is a single object
                        {{ $itemName }}Names.push(sessionData.name.toLowerCase());
                    }
                }

                // Clear existing disabled messages
                $('#{{ $itemName }}-select option[disabled]').remove();

                // Convert input to lowercase for comparison
                const inputTextLower = inputText.toLowerCase();

                // Check if the {{ $itemName }} is already in the session
                if ({{ $itemName }}Names.includes(inputTextLower)) {
                    $('#{{ $itemName }}-select')
                        .empty()
                        .append(`<option disabled>${inputText} already added.</option>`);
                    return;
                }

                // Handle empty {{ $itemName }} case
                $('#{{ $itemName }}-select').empty();
                {{ $itemName }}.forEach(function(item) {
                    // Check if this {{ $itemName }} is already in session
                    const isItemInSession = {{ $itemName }}Names.includes(item.name
                        .toLowerCase());

                    if (isItemInSession) {
                        $('#{{ $itemName }}-select').append(
                            `<option value="${item.id}" disabled>${item.name} (already added)</option>`
                        );
                    } else {
                        $('#{{ $itemName }}-select').append(
                            `<option value="${item.id}">${item.name}</option>`
                        );
                    }
                });
            } catch (error) {
                console.error("Error in update{{ $itemName }}Suggestions:", error);
                $('#{{ $itemName }}-select')
                    .empty()
                    .append(
                        `<option disabled>Error loading {{ $itemName }}. Please try again.</option>`);
            }
        }

        // Remove item from session and display
        // Remove item from session and display
        $(document).on('click', '#{{ $itemName }}-remove-btn', function() {
            const idToRemove = $(this).data('id');
            const currentInputText = $('#{{ $itemInputField }}').val().trim().toLowerCase();

            // Remove item from session via AJAX
            $.post('{{ $removeItemSelectionRoute }}', {
                id: idToRemove
            }, function(response) {
                updateSessionData(response.{{ $selectItems }});

                // Only refresh options if there's input text of 3 or more characters
                if (currentInputText.length >= 3) {
                    // Perform new search to get updated suggestions
                    $.post('{{ $itemSearchRoute }}', {
                        keyword: currentInputText
                    }, function(searchResponse) {
                        // Get current selected {{ $itemName }} IDs after removal
                        const {{ $selectItems }}Ids = $(
                            '#{{ $itemName }}-session-data .item').map(
                            function() {
                                return $(this).data('id');
                            }).get();

                        // Filter out any already selected {{ $itemName }}
                        const filtered{{ $itemName }} = searchResponse
                            .{{ $itemName }}.filter(
                                {{ $itemName }} =>
                                !{{ $selectItems }}Ids.includes({{ $itemName }}
                                    .id)
                            );

                        // Update the suggestions dropdown
                        debugger
                        console.log('test2')
                        update{{ $itemName }}Suggestions(
                            filtered{{ $itemName }}, currentInputText);
                    });
                } else {
                    // Clear the dropdown if input is less than 3 characters
                    $('#{{ $itemName }}-select').empty();
                }
            });
        });
    });
</script>
