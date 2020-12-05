<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Import extends Component
{
    /**
    * Create a new component instance.
    *
    * @return void
    */

    public $route;
    public $message;

    public function __construct($route, $message=null)
    {
        //
        $this->message = $message;
        $this->route = $route;
    }

    /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
    public function render()
    {
        return view('components.forms.import');
    }
}
