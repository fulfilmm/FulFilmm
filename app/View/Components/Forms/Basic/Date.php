<?php

namespace App\View\Components\Forms\Basic;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Date extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name, $title, $required, $value, $message;

    public function __construct($name, $title, $required, $value, $message=null)
    {
        //
        $this->name = $name;
        $this->title = $title;
        $this->required = $required;
        $this->value = $value;
        $this->$message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.forms.basic.date');
    }
}
