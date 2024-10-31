@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-6">Additional Advices</h1>

        <form action="{{ route('additional_advice.store') }}" method="POST">
            @csrf
            <div class="max-w-md mx-auto">
                <x-prescriptions.form-field
                    name="name"
                    label="Name"
                    required
                    placeholder="Enter name"
                />

                <x-prescriptions.form-field
                    name="description"
                    label="Description"
                    type="textarea"
                    placeholder="Enter description"
                />

                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Submit Now
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
