<?php
namespace App\View\Components\Forms\Basic;

use Illuminate\View\Component;

class Input extends Component
{
    /**
    * Create a new component instance.
    *
    * @return void
    */

    public $name, $type,  $title, $required, $value, $message;

    public function __construct($name, $title, $required, $value, $type="text", $message=null)
    {
        //
        $this->name = $name;
        $this->type = $type;
        $this->title = $title;
        $this->required = $required;
        $this->value = $value;
        $this->$message = $message;
    }

    /**
    * Get the view / contents that represent the component.
    *
    * @return \Illuminate\Contracts\View\View|string
    */
    public function render()
    {
        return view('components.forms.basic.input');
    }
}
