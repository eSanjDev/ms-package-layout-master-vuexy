<?php

namespace App\View\Components;

use Closure;
use Esanj\Manager\Models\Manager;
use Esanj\Manager\Services\ManagerService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Menu extends Component
{
    private Manager $manager;

    /**
     * Create a new component instance.
     */
    public function __construct(protected ManagerService $managerService)
    {
    }

    /**
     * Get the view / contents that represent the component.
     * @throws AuthenticationException
     */
    public function render(): View|Closure|string
    {
        $menuJson = file_get_contents(resource_path('menu/admin.json'));
        $menuArray = json_decode($menuJson, true);

        if (!Auth::guard('manager')->check()) {
            throw new AuthenticationException();
        }

        $managerId = Auth::guard('manager')->id();
        $this->manager = $this->managerService->findById($managerId);

        $menuData = ['menu' => $this->filterMenu($menuArray['menu'])];

        $currentRouteName = Route::currentRouteName();

        return view('components.menu', compact('menuData', 'currentRouteName'));
    }

    protected function filterMenu(array $menu): array
    {
        return collect($menu)->map(function ($item) {

            if (!empty($item['permission']) && !$this->managerService->hasPermission($this->manager->id, $item['permission'])) {
                return null;
            }

            if (!empty($item['submenu'])) {
                $item['submenu'] = collect($item['submenu'])
                    ->filter(function ($subItem) {
                        return empty($subItem['permission'] && !$this->managerService->hasPermission($this->manager->id, $subItem['permission']));
                    })
                    ->values()
                    ->toArray();

                if (empty($item['submenu'])) {
                    return null;
                }
            }

            return $item;
        })->filter()->values()->toArray();
    }
}
