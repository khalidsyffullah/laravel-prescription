@extends('layouts.app')

@section('content')
    <h1>Prescription</h1>

    {{-- Diagnosis Search Component --}}
    <x-prescriptions.prescription-search-select-component label="Search Diagnosis"
        searchRoute="{{ route('prescription.searchDiagonosis') }}" storeRoute="{{ route('diagonosis.store') }}"
        placeholder="Enter diagnosis name" identifier="diagnosis" />

    {{-- Additional Advice Search Component --}}
    <x-prescriptions.prescription-search-select-component label="Search Additional Advice"
        searchRoute="{{ route('prescription.searchAdditionalAdvice') }}" storeRoute="{{ route('additional_advice.store') }}"
        placeholder="Enter additional advice name" identifier="additional_advice" />

    {{-- advice investigation search component --}}
    <x-prescriptions.prescription-search-select-component label="Search advice Investigation"
        searchRoute="{{ route('prescription.searchAdviceInvestigation') }}"
        storeRoute="{{ route('advice_investigation.store') }}" placeholder="Enter advice Investigation name"
        identifier="AdviceInvestigation" />

    {{-- tests search component --}}
    <x-prescriptions.prescription-search-select-component label="Search Test"
        searchRoute="{{ route('prescription.searchadviceTest') }}" storeRoute="{{ route('tests.store') }}"
        placeholder="Enter tests name" identifier="adviceTest" />

    <button type="button" title="Add new drug group" class="btn btn-primary add_drug_group"><i class="fa fa-plus-circle"></i> Add Drug Group</button>

    {{-- Main drug groups container --}}
    <div id="drug-groups-container">
        <div class="drug-group" data-group-index="0">
            {{-- search drugs components --}}
            <div class="drug-container">
                <x-prescriptions.prescription-search-select-component label="Search Drugs"
                    searchRoute="{{ route('prescription.searchdrug') }}" storeRoute="{{ route('drugs.store') }}"
                    placeholder="Enter drugs name" identifier="drugs" />

                {{-- Main Drugs Essentials Container --}}
                <div class="drugs-essentials-container">
                    <div class="drugs-essentials" data-index="0">
                        @foreach (range(0, 3) as $i)
                            <div class="drug-time-period">
                                <select name="time_periods[0][0][]" class="form-control">
                                    <option value=""></option>
                                    <option value="0">0</option>
                                    <option value="½">½</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="0.5 ml">0.5 ml</option>
                                    <option value="1 ml">1 ml</option>
                                    <option value="2 ml">2 ml</option>
                                    <option value="3 ml">3 ml</option>
                                    <option value="4 ml">4 ml</option>
                                    <option value="5 ml">5 ml</option>
                                </select>
                            </div>
                        @endforeach

                        <div class="drug-duration">
                            <select name="duration_text[0][0][]" class="form-control">
                                <option value="">Select</option>
                                @foreach (range(1, 31) as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>

                            <select name="duration[0][0][]" class="form-control">
                                <option value="">Time</option>
                                <option value="Continue">Continue</option>
                                <option value="Days">Days</option>
                                <option value="Months">Months</option>
                                <option value="Years">Years</option>
                            </select>

                            <select name="medicine_time[0][0][]" class="form-control">
                                <option value="">Before/After Meals</option>
                                <option value="After Meal">After Meal</option>
                                <option value="Before Meal">Before Meal</option>
                            </select>
                        </div>

                        <input type="text" name="note[0][0][]" class="form-control" placeholder="Enter Note">
                        <button type="button" title="Add new row" class="btn btn-light-primary add_drug_essential">Add More</button>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-danger remove_drug_group" title="Remove drug group">Remove Group</button>
        </div>
    </div>

    {{-- search patients components --}}
    <x-prescriptions.prescription-search-select-component label="Search Patients"
        searchRoute="{{ route('prescription.searchpatientDetail') }}" storeRoute="{{ route('patient.store') }}"
        placeholder="Enter Patient name" identifier="Patients" />
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


@endsection
