@extends('layouts.app')

@section('content')
    <h1>Prescription</h1>

    {{-- Diagnosis Search Component --}}
    <x-prescriptions.prescription-search-select-component
        label="Search Diagnosis"
        searchRoute="{{ route('prescription.searchDiagonosis') }}"
        storeRoute="{{ route('diagonosis.store') }}"
        placeholder="Enter diagnosis name"
        identifier="diagnosis"
    />

    {{-- Additional Advice Search Component --}}
    <x-prescriptions.prescription-search-select-component
        label="Search Additional Advice"
        searchRoute="{{ route('prescription.searchAdditionalAdvice') }}"
        storeRoute="{{ route('additional_advice.store') }}"
        placeholder="Enter additional advice name"
        identifier="additional_advice"
    />
@endsection
