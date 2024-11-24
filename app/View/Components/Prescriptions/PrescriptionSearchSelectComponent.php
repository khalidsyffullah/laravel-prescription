<?php
namespace App\View\Components\Prescriptions;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PrescriptionSearchSelectComponent extends Component
{
    public string $checkItemInSessionRoute;
    public string $itemSearchRoute;
    public string $storeItemSelectionRoute;
    public string $itemStoreRoute;
    public string $removeItemSelectionRoute;
    public string $itemInputField;
    public string $itemName;
    public string $selectItems;
    // public string $selectedItemsId;
    public string $sesssionOptionId;
    public string $sessionOptionName;


    public function __construct(
        string $checkItemInSessionRoute,
        string $itemSearchRoute,
        string $storeItemSelectionRoute,
        string $itemStoreRoute,
        string $removeItemSelectionRoute,
        string $itemInputField,
        string $itemName,
        string $selectItems,
    ) {
        $this->checkItemInSessionRoute = $checkItemInSessionRoute;
        $this->itemSearchRoute = $itemSearchRoute;
        $this->storeItemSelectionRoute = $storeItemSelectionRoute;
        $this->itemStoreRoute = $itemStoreRoute;
        $this->removeItemSelectionRoute = $removeItemSelectionRoute;
        $this->itemInputField = $itemInputField;
        $this->itemName = $itemName;
        $this->selectItems = $selectItems;
        $this->sesssionOptionId = "{$itemName}.id";
        $this->sessionOptionName = "{$itemName}.name";


    }

    public function render(): View
    {
        // Get the data from the parent view's session
        $selectedItems = session($this->selectItems, []);

        return view('components.prescriptions.prescription-search-select-component', [
            'selectedItems' => $selectedItems
        ]);
    }
}
