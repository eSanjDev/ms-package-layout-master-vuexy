<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class SubMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $data)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menu = $this->data;
        $currentRouteName = Route::currentRouteName();

        return view('components.sub-menu', compact('menu', 'currentRouteName'));
    }
}
