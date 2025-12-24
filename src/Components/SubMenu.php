<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class SubMenu extends Component
{
    public function __construct(
        public array $data
    ) {}

    public function render(): View|Closure|string
    {
        $menu = $this->data;
        $currentRouteName = Route::currentRouteName();

        return view('components.sub-menu', compact('menu', 'currentRouteName'));
    }
}