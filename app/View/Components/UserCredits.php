<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;

class UserCredits extends Component
{
    public $credit_amount;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($amount)
    {
        $this->credit_amount = $amount;
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


