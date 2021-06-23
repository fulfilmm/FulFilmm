<?php

namespace App\View\Components\Partials;

use Illuminate\View\Component;

class Card extends Component
{

    /**
     * The card route.
     *
     * @var string
     */
    public $route;

    /**
     * The card title.
     *
     * @var string
     */
    public $title;

    /**
     * The card id.
     *
     * @var string
     */
    public $id;

    /**
     * The card subtitle.
     *
     * @var string
     */
    public $subtitle;

    /**
     * The card image.
     *
     * @var string
     */
    public $image;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route, $id, $title, $subtitle = '', $image = '')
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->id = $id;
        $this->route = $route;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.partials.card');
    }
}
