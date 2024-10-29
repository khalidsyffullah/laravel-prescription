@extends('layouts.app')

@section('content')
    <form action="{{ route('advice_investigation.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            @error('name')
                <div>{{ $message }}</div>
            @enderror

        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
        </div>

        @error('descriptions')
            <div>
                {{ $message }}
            </div>
        @enderror
        <button type="submit">Submit now</button>
    </form>
@endsection
