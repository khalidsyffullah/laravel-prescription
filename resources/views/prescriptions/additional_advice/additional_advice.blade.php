@extends('layouts.app')

@section('content')
    <h1>Additional Advices</h1>

    <form action="{{route('additional_advice.store')}}" method="POST">
        @csrf
        <div>
            <input type="text" id="name" class="name" name="name">

            <div>
                @error('name')
                    <div>{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div>
            <textarea name="description" id="description" class="description" cols="30" rows="10"></textarea>
            @error('description')
            <div>{{$message}}</div>

            @enderror
        </div>
        <button type="submit">Submit Now</button>
    </form>
@endsection
