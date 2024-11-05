<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Assuming you have CSS --> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


</head>

<body>

    <!-- Header Section -->
    @include('layouts.partials.header')

    <div class="container">
        <!-- Dynamic Content Section -->
        @yield('content')
    </div>

    <!-- Footer Section -->
    @include('layouts.partials.footer')

    {{-- <script src="{{ asset('js/app.js') }}"></script> <!-- Assuming you have JS --> --}}
</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        let groupIndex = 0;

        // Add new drug group
        $('.add_drug_group').click(function() {
            groupIndex++;

            // Clone the first drug group
            const newGroup = $('.drug-group:first').clone();

            // Update group index
            newGroup.attr('data-group-index', groupIndex);

            // Reset the drugs-essentials container to have only one row
            const firstEssential = newGroup.find('.drugs-essentials:first').clone();
            newGroup.find('.drugs-essentials-container').empty().append(firstEssential);

            // Update all name attributes with new group index
            updateNameAttributes(newGroup, groupIndex, 0);

            // Reset all values
            newGroup.find('select, input').val('');

            // Ensure remove button exists
            if (!newGroup.find('.remove_drug_group').length) {
                newGroup.append(
                    '<button type="button" class="btn btn-danger remove_drug_group" title="Remove drug group">Remove Group</button>'
                    );
            }

            // Append the new group
            $('#drug-groups-container').append(newGroup);
        });

        // Remove drug group
        $(document).on('click', '.remove_drug_group', function() {
            if ($('.drug-group').length > 1) {
                $(this).closest('.drug-group').remove();
            }
        });

        // Add new drug essential row
        $(document).on('click', '.add_drug_essential', function() {
            const groupContainer = $(this).closest('.drug-group');
            const groupIndex = groupContainer.data('group-index');
            const essentialsContainer = $(this).closest('.drugs-essentials-container');
            const rowIndex = essentialsContainer.find('.drugs-essentials').length;

            // Clone the first drugs-essentials div within this group
            const newRow = essentialsContainer.find('.drugs-essentials:first').clone();

            // Update name attributes for the new row
            updateNameAttributes(newRow, groupIndex, rowIndex);

            // Reset all values
            newRow.find('select, input').val('');

            // Add remove button if it doesn't exist
            if (!newRow.find('.remove_drug_essential').length) {
                newRow.append(
                    '<button type="button" class="btn btn-danger remove_drug_essential" title="Remove this row">Remove</button>'
                    );
            }

            // Append the new row
            essentialsContainer.append(newRow);
        });

        // Remove drug essential row
        $(document).on('click', '.remove_drug_essential', function() {
            const essentialsContainer = $(this).closest('.drugs-essentials-container');
            if (essentialsContainer.find('.drugs-essentials').length > 1) {
                $(this).closest('.drugs-essentials').remove();
            }
        });

        // Helper function to update name attributes
        function updateNameAttributes(element, groupIndex, rowIndex) {
            element.find('select[name^="time_periods"]').attr('name',
                `time_periods[${groupIndex}][${rowIndex}][]`);
            element.find('select[name^="duration_text"]').attr('name',
                `duration_text[${groupIndex}][${rowIndex}][]`);
            element.find('select[name^="duration"]').attr('name', `duration[${groupIndex}][${rowIndex}][]`);
            element.find('select[name^="medicine_time"]').attr('name',
                `medicine_time[${groupIndex}][${rowIndex}][]`);
            element.find('input[name^="note"]').attr('name', `note[${groupIndex}][${rowIndex}][]`);
        }
    });
</script>

</html>
