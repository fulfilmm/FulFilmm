<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
        /**
     * The modal title.
     *
     * @var string
     */
    public $title;

    /**
     * The modal id.
     *
     * @var string
     */
    public $id;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $id)
    {
        $this->title = $title;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
