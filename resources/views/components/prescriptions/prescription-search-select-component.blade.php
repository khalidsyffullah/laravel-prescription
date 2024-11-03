<div>
    <label for="{{ $searchInputId }}">{{ $label }}:</label>
    <input type="text" id="{{ $searchInputId }}" placeholder="{{ $placeholder }}">

    <select id="{{ $suggestionsId }}" multiple size="5" style="width: 100%;"></select>

    <div id="{{ $selectedItemsId }}" style="margin-top: 10px;">
        <strong>Selected Items:</strong>
        <div id="{{ $selectedListId }}"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        function updateSuggestions(keyword, suggestionsId, selectedListId) {
            $.ajax({
                url: "{{ $searchRoute }}",
                method: 'GET',
                data: { keyword: keyword },
                success: function(data) {
                    $('#' + suggestionsId).empty();
                    const selectedNames = $('#' + selectedListId + ' div').map(function() {
                        return $(this).text().trim().replace(" Remove", "");
                    }).get();

                    let hasSuggestions = false;
                    data.forEach(function(item) {
                        if (!selectedNames.includes(item.name)) {
                            $('#' + suggestionsId).append(
                                `<option value="${item.id}">${item.name}</option>`
                            );
                            hasSuggestions = true;
                        }
                    });
                    if (!hasSuggestions) {
                        $('#' + suggestionsId).append(`<option value="">No matches found</option>`);
                    }
                }
            });
        }

        function addToSelectedList(id, name, selectedListId, suggestionsId) {
            $('#' + selectedListId).append(
                `<div data-id="${id}">${name} <button class="remove">Remove</button></div>`
            );
            $('#' + suggestionsId + ' option[value="' + id + '"]').remove();
        }

        function findExactMatchInSuggestions(name, suggestionsId) {
            let match = null;
            $('#' + suggestionsId + ' option').each(function() {
                if ($(this).text().toLowerCase() === name.toLowerCase()) {
                    match = { id: $(this).val(), name: $(this).text() };
                    return false;
                }
            });
            return match;
        }

        $('#{{ $searchInputId }}').on('input', function() {
            const keyword = $(this).val();
            if (keyword.length >= 3) {
                updateSuggestions(keyword, '{{ $suggestionsId }}', '{{ $selectedListId }}');
            } else {
                $('#' + '{{ $suggestionsId }}').empty();
            }
        });

        $('#{{ $suggestionsId }}').on('change', function() {
            const newSelection = $('#' + '{{ $suggestionsId }} option:selected');
            newSelection.each(function() {
                const selectedId = $(this).val();
                const selectedName = $(this).text();
                if (selectedName) {
                    addToSelectedList(selectedId, selectedName, '{{ $selectedListId }}', '{{ $suggestionsId }}');
                }
            });
            $('#{{ $searchInputId }}').val('');
        });

        $('#{{ $searchInputId }}').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                const name = $(this).val().trim();
                const existsInSelected = $('#' + '{{ $selectedListId }} div').toArray()
                    .some(div => $(div).text().trim().replace(" Remove", "").toLowerCase() === name.toLowerCase());

                if (existsInSelected) {
                    alert('This item is already selected.');
                    return;
                }

                const exactMatch = findExactMatchInSuggestions(name, '{{ $suggestionsId }}');
                if (exactMatch) {
                    addToSelectedList(exactMatch.id, exactMatch.name, '{{ $selectedListId }}', '{{ $suggestionsId }}');
                    $(this).val('');
                    $('#' + '{{ $suggestionsId }}').empty();
                } else {
                    $.ajax({
                        url: "{{ $storeRoute }}",
                        method: 'POST',
                        data: {
                            name: name,
                            descriptions: "",
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            addToSelectedList(data.id, data.name, '{{ $selectedListId }}', '{{ $suggestionsId }}');
                            $('#{{ $searchInputId }}').val('');
                            $('#' + '{{ $suggestionsId }}').empty();
                        }
                    });
                }
            }
        });

        $(document).on('click', '.remove', function() {
            const nameToRemove = $(this).parent().text().trim().replace(" Remove", "");
            const idToRemove = $(this).parent().data('id');
            $(this).parent().remove();
            $('#' + '{{ $suggestionsId }}').append(
                `<option value="${idToRemove}">${nameToRemove}</option>`
            );
        });
    });
</script>
