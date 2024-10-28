@extends('layouts.app')

@section('content')
    <h1>Prescription</h1>

    <div>
        <label for="diagonosis_search">Search Diagonosis:</label>
        <input type="text" id="diagonosis_search" placeholder="Enter diagnosis name">

        <select id="suggestions" multiple size="5" style="width: 100%;"></select>

        <div id="selected_items" style="margin-top: 10px;">
            <strong>Selected Diagnoses:</strong>
            <div id="selected_list"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function updateSuggestions(keyword) {
                $.ajax({
                    url: "{{ route('prescription.search') }}",
                    method: 'GET',
                    data: {
                        keyword: keyword
                    },
                    success: function(data) {
                        $('#suggestions').empty();
                        const selectedNames = $('#selected_list div').map(function() {
                            return $(this).text().trim().replace(" Remove", "");
                        }).get();

                        let hasSuggestions = false;

                        data.forEach(function(item) {
                            if (!selectedNames.includes(item.name)) {
                                $('#suggestions').append(
                                    `<option value="${item.id}">${item.name}</option>`
                                );
                                hasSuggestions = true;
                            }
                        });

                        if (!hasSuggestions) {
                            $('#suggestions').append(`<option value="">No matches found</option>`);
                        }
                    }
                });
            }

            function addToSelectedList(id, name) {
                $('#selected_list').append(
                    `<div data-id="${id}">${name} <button class="remove">Remove</button></div>`
                );
                // Remove from suggestions if it exists
                $(`#suggestions option[value="${id}"]`).remove();
            }

            function findExactMatchInSuggestions(name) {
                let match = null;
                $('#suggestions option').each(function() {
                    if ($(this).text().toLowerCase() === name.toLowerCase()) {
                        match = {
                            id: $(this).val(),
                            name: $(this).text()
                        };
                        return false; // Break the loop
                    }
                });
                return match;
            }

            $('#diagonosis_search').on('input', function() {
                const keyword = $(this).val();
                if (keyword.length >= 3) {
                    updateSuggestions(keyword);
                } else {
                    $('#suggestions').empty();
                }
            });

            $('#suggestions').on('change', function() {
                const newSelection = $('#suggestions option:selected');
                newSelection.each(function() {
                    const selectedId = $(this).val();
                    const selectedName = $(this).text();
                    if (selectedName) {
                        addToSelectedList(selectedId, selectedName);
                    }
                });
                $('#diagonosis_search').val('');
            });

            $('#diagonosis_search').on('keypress', function(e) {
                if (e.which == 13) {
                    e.preventDefault();
                    const name = $(this).val().trim();
                    const existsInSelected = $('#selected_list div').toArray()
                        .some(div => $(div).text().trim().replace(" Remove", "").toLowerCase() === name
                            .toLowerCase());

                    if (existsInSelected) {
                        alert('This diagnosis is already selected.');
                        return;
                    }

                    const exactMatch = findExactMatchInSuggestions(name);
                    if (exactMatch) {
                        addToSelectedList(exactMatch.id, exactMatch.name);
                        $(this).val('');
                        $('#suggestions').empty();
                    } else {
                        // Create new diagnosis
                        $.ajax({
                            url: "{{ route('prescription.store') }}",
                            method: 'POST',
                            data: {
                                name: name,
                                descriptions: "",
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                addToSelectedList(data.id, data.name);
                                $('#diagonosis_search').val('');
                                $('#suggestions').empty();
                            }
                        });
                    }
                }
            });

            $(document).on('click', '.remove', function() {
                const nameToRemove = $(this).parent().text().trim().replace(" Remove", "");
                const idToRemove = $(this).parent().data('id');
                $(this).parent().remove();
                $('#suggestions').append(
                    `<option value="${idToRemove}">${nameToRemove}</option>`
                );
            });

        });
    </script>
@endsection
