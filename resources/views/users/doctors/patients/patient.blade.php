{{-- resources/views/users/doctors/patients/patient.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Patient Registration') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div id="messageAlert" style="display: none;" class="alert">
                        <!-- Dynamic messages will be shown here -->
                    </div>

                    <form id="patientForm" method="POST" action="{{ route('patient.store') }}">
                        @csrf
                        <input type="hidden" id="patient_id" name="patient_id">

                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone_no">Phone Number</label>
                            <input type="text" class="form-control @error('phone_no') is-invalid @enderror"
                                   id="phone_no" name="phone_no" value="{{ old('phone_no') }}">
                            @error('phone_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="age">Age</label>
                            <input type="text" class="form-control @error('age') is-invalid @enderror"
                                   id="age" name="age" value="{{ old('age') }}">
                            @error('age')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="weight">Weight</label>
                            <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror"
                                   id="weight" name="weight" value="{{ old('weight') }}">
                            @error('weight')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Gender</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="male"
                                       value="male" {{ old('gender', 'male') === 'male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" id="female"
                                       value="female" {{ old('gender') === 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            @error('gender')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
                        <button type="button" id="updateBtn" class="btn btn-success" style="display: none;">Link Patient</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let typingTimer;
    const doneTypingInterval = 1000; // 1 second

    function showMessage(message, type) {
        const alertDiv = $('#messageAlert');
        alertDiv.removeClass('alert-success alert-danger')
                .addClass(`alert-${type}`)
                .html(message)
                .show();
    }

    $('#name, #phone_no').on('keyup', function() {
        clearTimeout(typingTimer);
        if ($('#name').val() && $('#phone_no').val()) {
            typingTimer = setTimeout(checkPatient, doneTypingInterval);
        }
    });

    function checkPatient() {
        const name = $('#name').val();
        const phone = $('#phone_no').val();

        $.ajax({
            url: '{{ route("check.patient") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: name,
                phone_no: phone
            },
            success: function(response) {
                if (response.exists) {
                    // Set patient ID in hidden field
                    $('#patient_id').val(response.patient.id);

                    // Autofill form
                    $('#email').val(response.patient.email);
                    $('#age').val(response.patient.age);
                    $('#weight').val(response.patient.weight);
                    $(`#${response.patient.gender}`).prop('checked', true);

                    if (response.isLinked) {
                        // If already linked, show message and disable both buttons
                        showMessage('This patient is already linked to your account', 'info');
                        $('#submitBtn, #updateBtn').hide();
                    } else {
                        // Show update button, hide submit button
                        $('#submitBtn').hide();
                        $('#updateBtn').show();
                        $('#messageAlert').hide();
                    }

                    // Disable form fields
                    $('form input').not('#name, #phone_no').prop('disabled', true);
                } else {
                    // Clear form except name and phone
                    $('#patient_id').val('');
                    $('#email').val('');
                    $('#age').val('');
                    $('#weight').val('');
                    $('#male').prop('checked', true);

                    // Show submit button, hide update button
                    $('#submitBtn').show();
                    $('#updateBtn').hide();
                    $('#messageAlert').hide();

                    // Enable form fields
                    $('form input').prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking patient:', error);
                showMessage('Error checking patient details', 'danger');
            }
        });
    }

    // Handle update button click
    $('#updateBtn').click(function(e) {
        e.preventDefault();
        const patientId = $('#patient_id').val();

        $.ajax({
            url: '{{ route("patient.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                patient_id: patientId
            },
            success: function(response) {
                if (response.status === 'success') {
                    showMessage(response.message, 'success');
                    $('#updateBtn').hide();
                } else {
                    showMessage(response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                showMessage('Error processing request', 'danger');
            }
        });
    });
});
</script>
@endpush
