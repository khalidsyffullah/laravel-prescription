@extends('layouts.app')

@section('content')

<form action="{{route('tests.store')}}" method="POST">
    @csrf
    <label for="name">Name</label>
    <input type="text" name="name" id="name" class="name">
    <label for="details">Details</label>
    <textarea name="details" id="details" cols="30" rows="10"></textarea>

    <button type="submit">Submit</button>
</form>

@endsection()
