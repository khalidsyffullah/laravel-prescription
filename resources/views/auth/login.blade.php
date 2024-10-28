@extends('layouts.app')

@section('content')
<div class="login-container">
    <h2>Login</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="email_or_phone">Email or Phone:</label>
            <input type="text" id="email_or_phone" name="email_or_phone" value="{{ old('email_or_phone') }}">
            @error('email_or_phone')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Login</button>
    </form>

    @error('inactive')
        <div class="error-message">
            {{ $message }}
        </div>
    @enderror

    @error('login')
        <div class="error-message">
            {{ $message }}
        </div>
    @enderror
</div>
@endsection
