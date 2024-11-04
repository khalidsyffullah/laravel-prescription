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


    <x-prescriptions.prescription-search-select-component
        label="Search advice Investigation"
        searchRoute="{{ route('prescription.searchAdviceInvestigation') }}"
        storeRoute="{{ route('advice_investigation.store') }}"
        placeholder="Enter advice Investigation name"
        identifier="AdviceInvestigation"
    />

    <x-prescriptions.prescription-search-select-component
        label="Search Test"
        searchRoute="{{ route('prescription.searchadviceTest') }}"
        storeRoute="{{ route('tests.store') }}"
        placeholder="Enter tests name"
        identifier="adviceTest"
    />

    <x-prescriptions.prescription-search-select-component
        label="Search Drugs"
        searchRoute="{{ route('prescription.searchdrug') }}"
        storeRoute="{{ route('drugs.store') }}"
        placeholder="Enter drugs name"
        identifier="drugs"
    />

    <x-prescriptions.prescription-search-select-component
        label="Search Patients"
        searchRoute="{{ route('prescription.searchpatientDetail') }}"
        storeRoute="{{ route('patient.store') }}"
        placeholder="Enter Patient name"
        identifier="Patients"
    />
@endsection
