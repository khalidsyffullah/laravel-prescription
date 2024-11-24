<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .session-data .item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .remove-btn {
            margin-left: 10px;
            cursor: pointer;
            color: red;
        }
    </style>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="input-section">
        <input type="text" class="input-field" id="input-field" placeholder="Type a diagnosis name and press Enter">

        <!-- Diagnosis multiple selection dropdown -->
        <select class="option-select" id="diagnosis-select" multiple>
        </select>
    </div>

    <div class="session-data">
        <!-- Display existing session data on page load -->
        @foreach ($selectedDiagnoses as $diagnosis)
            <div class="item" data-id="{{ $diagnosis['id'] }}">
                {{ $diagnosis['name'] }} (ID: {{ $diagnosis['id'] }})
                <span class="remove-btn" data-id="{{ $diagnosis['id'] }}">Remove</span>
            </div>
        @endforeach
    </div>

    <script>
        $(document).ready(function() {
            //CSRF token setup for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle input field keyup event
            $('#input-field').on('keyup', function(e) {
                debugger
                const inputText = $(this).val().trim().toLowerCase();

                // Only perform search if the input length is at least 3 characters
                if (inputText.length >= 3) {
                    debugger
                    // Send search request to the server
                    $.post('{{ route('diagnosis.search') }}', {
                        keyword: inputText
                    }, function(response) {
                        debugger
                        // Remove any already selected diagnoses from suggestions
                        const selectedDiagnosesIds = $('.session-data .item').map(function() {
                            return $(this).data('id');
                        }).get();

                        const filteredDiagnoses = response.diagnoses.filter(diagnosis =>
                            !selectedDiagnosesIds.includes(diagnosis.id)
                        );
                        debugger

                        updateDiagnosisSuggestions(filteredDiagnoses, inputText);
                    });
                } else {
                    // Clear the diagnosis suggestions dropdown
                    $('#diagnosis-select').empty();
                }

                // Handle "Enter" key press on input field
                if (e.key === 'Enter') {
                    debugger
                    e.preventDefault(); // Prevent form submission

                    const inputText = $('#input-field').val().trim().toLowerCase();

                    // Check if the input text already exists in the session
                    const existingItem = $('.session-data .item').filter(function() {
                        return $(this).text().toLowerCase().includes(inputText);
                    });


                    // Find matching option in the dropdown by name
                    const matchingOption = $('#diagnosis-select option').filter(function() {
                        return $(this).text().toLowerCase() === inputText;
                    });

                    if (matchingOption.length > 0) {
                        const id = matchingOption.val();
                        const name = matchingOption.text();

                        // Send matched selection to server for storing in session
                        $.post('{{ route('store.selection') }}', {
                            id: id,
                            name: name
                        }, function(response) {
                            updateSessionData(response.selectedDiagnoses);

                            // Clear the input field and the suggestions dropdown
                            $('#input-field').val('');
                            $('#diagnosis-select').empty();
                        });
                    } else {
                        // If no match found, create a new diagnosis
                        $.post('{{ route('diagnosis.store') }}', {
                            name: inputText
                        }, function(response) {
                            $.post('{{ route('store.selection') }}', {
                                id: response.diagnosis.id,
                                name: response.diagnosis.name
                            }, function(response) {
                                updateSessionData(response.selectedDiagnoses);

                                // Clear the input field and the suggestions dropdown
                                $('#input-field').val('');
                                $('#diagnosis-select').empty();
                            });
                        });
                    }

                }
            });

            // Handle selection change from dropdown
            $('#diagnosis-select').on('change', function() {
                $('#diagnosis-select option:selected').each(function() {
                    const id = $(this).val();
                    const name = $(this).text();

                    // Send selection to server for storing in session
                    $.post('{{ route('store.selection') }}', {
                        id: id,
                        name: name
                    }, (response) => {
                        updateSessionData(response.selectedDiagnoses);

                        // Remove the selected option from the dropdown
                        $(this).remove();
                    });
                });
            });

            // Function to update session data display
            function updateSessionData(selectedDiagnoses) {
                debugger
                $('.session-data').empty();

                // Display each selected diagnosis
                selectedDiagnoses.forEach(function(item) {
                    $('.session-data').append(
                        `<div class="item" data-id="${item.id}">
                    ${item.name} (ID: ${item.id})
                    <span class="remove-btn" data-id="${item.id}">Remove</span>
                </div>`
                    );
                });
            }

            // Function to update diagnosis suggestions dropdown
            function updateDiagnosisSuggestions(diagnoses, inputText) {
                debugger;
                const sessionVal = @json($selectedDiagnoses);
                var diagnosisNames = [];

                sessionVal.forEach(diagnosis => {
                    diagnosisNames.push(diagnosis.name.toLowerCase());
                });

                // First, clear all existing disabled messages
                $('#diagnosis-select option[disabled]').remove();

                // Check if the diagnosis is already in the session
                if (diagnosisNames.includes(inputText)) {
                    $('#diagnosis-select').append(
                        `<option disabled>${inputText} already added.</option>`
                    );
                    return; // Exit function since we don't want to show other options
                }

                // Handle empty diagnoses case
                if (diagnoses.length === 0) {
                    $('#diagnosis-select').empty();
                    $('#diagnosis-select').append(
                        `<option disabled>${inputText} does not exist. Press Enter to create and add.</option>`
                    );
                    return; // Exit function as there's nothing else to show
                }

                // Handle diagnoses list
                if (diagnoses.length > 0) {
                    $('#diagnosis-select').empty();
                    // Add each diagnosis as an option in the dropdown
                    diagnoses.forEach(function(diagnosis) {
                        $('#diagnosis-select').append(
                            `<option value="${diagnosis.id}">${diagnosis.name}</option>`
                        );
                    });
                }
            }

            // Remove item from session and display
            // Remove item from session and display
            $(document).on('click', '.remove-btn', function() {
                const idToRemove = $(this).data('id');
                const currentInputText = $('#input-field').val().trim().toLowerCase();

                // Remove item from session via AJAX
                $.post('{{ route('remove.selection') }}', {
                    id: idToRemove
                }, function(response) {
                    updateSessionData(response.selectedDiagnoses);

                    // Only refresh options if there's input text of 3 or more characters
                    if (currentInputText.length >= 3) {
                        // Perform new search to get updated suggestions
                        $.post('{{ route('diagnosis.search') }}', {
                            keyword: currentInputText
                        }, function(searchResponse) {
                            debugger
                            // Get current selected diagnoses IDs after removal
                            const selectedDiagnosesIds = $('.session-data .item').map(
                                function() {
                                    return $(this).data('id');
                                }).get();

                            // Filter out any already selected diagnoses
                            const filteredDiagnoses = searchResponse.diagnoses.filter(
                                diagnosis =>
                                !selectedDiagnosesIds.includes(diagnosis.id)
                            );
                            debugger
                            // Update the suggestions dropdown
                            updateDiagnosisSuggestions(filteredDiagnoses, currentInputText);
                        });
                    } else {
                        // Clear the dropdown if input is less than 3 characters
                        $('#diagnosis-select').empty();
                    }
                });
            });
        });
    </script>
</body>

</html>
