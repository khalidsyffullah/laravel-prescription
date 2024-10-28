<!-- resources/views/prescriptions/diagonosis/diagonosis.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Create Diagonosis</h1>
    <form action="{{ route('diagonosis.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="descriptions">Description:</label>
            <textarea name="descriptions" id="descriptions">{{ old('descriptions') }}</textarea>
            @error('descriptions')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Submit</button>
    </form>
@endsection
