<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;
use App\Http\Controllers\UserController;

class UserCredits extends Component
{
    public $credit_amount;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $cont = new UserController;
        $this->credit_amount = $cont->getRemainingCredits();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-credits');
    }
}


