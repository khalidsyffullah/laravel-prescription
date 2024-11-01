@extends('layouts.app')

@section('content')
<form action="{{route('drugs.store')}}" method="POSt">
    @csrf
    <label for="name"> Name</label>
    <input type="text" name="name" id="name" class="name" placeholder="Please enter your drugs name" required>

    <label for="generic_name">Generic name</label>
    <input type="text" name="generic_name" id="generic_name" class="generic_name">

    <label for="brand_name">Drugs Brand Name</label>
    <input type="text" name="brand_name" id="brand_name">

    <button type="submit"> Submit</button>

</form>
@endsection
