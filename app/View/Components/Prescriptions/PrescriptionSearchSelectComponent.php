<?php

namespace App\View\Components\Prescriptions;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PrescriptionSearchSelectComponent extends Component
{
    public string $label;
    public string $searchRoute;
    public string $storeRoute;
    public string $placeholder;
    public string $searchInputId;
    public string $suggestionsId;
    public string $selectedListId;
    public string $selectedItemsId;

    public function __construct(
        string $label,
        string $searchRoute,
        string $storeRoute,
        string $placeholder,
        string $identifier
    ) {
        $this->label = $label;
        $this->searchRoute = $searchRoute;
        $this->storeRoute = $storeRoute;
        $this->placeholder = $placeholder;
        $this->searchInputId = "{$identifier}_search";
        $this->suggestionsId = "{$identifier}_suggestions";
        $this->selectedListId = "{$identifier}_selected_list";
        $this->selectedItemsId = "{$identifier}_selected_items";
    }

    public function render(): View
    {
        return view('components.prescriptions.prescription-search-select-component');
    }
}
