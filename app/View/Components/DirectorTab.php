<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;
use App\Http\Controllers\UserController;

class DirectorTab extends Component
{
    public $is_director;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $cont = new UserController;
        $this->is_director = $cont->isDirector();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.director-tab');
    }
}
