<?php

namespace App\View\Components\prescriptions;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormField extends Component
{
    public $name;
    public $label;
    public $type;
    public $value;
    public $placeholder;
    public $required;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $label = '',
        string $type = 'text',
        string $value = '',
        string $placeholder = '',
        bool $required = false
    ) {
        $this->name = $name;
        $this->label = $label ?: ucfirst($name);
        $this->type = $type;
        $this->value = old($name, $value);
        $this->placeholder = $placeholder;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.prescriptions.form-field');
    }
}
