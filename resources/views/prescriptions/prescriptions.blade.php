@section('content')
    @extends('layouts.app')

    <h1>Prescription</h1>

    <x-prescriptions.prescription-search-select-component :check-item-in-session-route="route('additionalAdvice.checkSession')" :item-search-route="route('additionalAdvice.search')" :store-item-selection-route="route('additionalAdvice.store.selection')"
        :item-store-route="route('additionalAdvice.store')" :remove-item-selection-route="route('additionalAdvice.remove.selection')" :item-input-field="'additionalAdvice-input-field'" :item-name="'additionalAdvice'" :select-items="'selectedAdditionalAdvices'" />


    <x-prescriptions.prescription-search-select-component :check-item-in-session-route="route('adviceTest.checkSession')" :item-search-route="route('adviceTest.search')" :store-item-selection-route="route('adviceTest.store.selection')"
        :item-store-route="route('adviceTest.store')" :remove-item-selection-route="route('adviceTest.remove.selection')" :item-input-field="'adviceTest-input-field'" :item-name="'adviceTest'" :select-items="'selectedAdviceTests'" />

    <x-prescriptions.prescription-search-select-component :check-item-in-session-route="route('adviceInvestigation.checkSession')" :item-search-route="route('adviceInvestigation.search')" :store-item-selection-route="route('adviceInvestigation.store.selection')"
        :item-store-route="route('adviceInvestigation.store')" :remove-item-selection-route="route('adviceInvestigation.remove.selection')" :item-input-field="'adviceInvestigation-input-field'" :item-name="'adviceInvestigation'" :select-items="'selectedAdviceInvestigations'" />

    <x-prescriptions.prescription-search-select-component :check-item-in-session-route="route('diagnosis.checkSession')" :item-search-route="route('diagnosis.search')" :store-item-selection-route="route('diagnosis.store.selection')"
        :item-store-route="route('diagnosis.store')" :remove-item-selection-route="route('diagnosis.remove.selection')" :item-input-field="'diagnosis-input-field'" :item-name="'diagnosis'" :select-items="'selectedDiagnoses'" />

    <x-prescriptions.prescription-search-select-component :check-item-in-session-route="route('drug.checkSession')" :item-search-route="route('drug.search')" :store-item-selection-route="route('drug.store.selection')"
        :item-store-route="route('drug.store')" :remove-item-selection-route="route('drug.remove.selection')" :item-input-field="'drug-input-field'" :item-name="'drug'" :select-items="'selectedDrugs'" />
@endsection
