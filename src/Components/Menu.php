<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Esanj\Manager\Models\Manager;
use Esanj\Manager\Services\ManagerService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use RuntimeException;

class Menu extends Component
{
    private const MENU_PATH = 'menu/admin.json';

    private ?Manager $manager = null;

    public function __construct(
        protected ManagerService $managerService
    ) {}

    /**
     * @throws AuthenticationException
     */
    public function render(): View|Closure|string
    {
        $this->ensureAuthenticated();

        $menuArray = $this->loadMenuData();
        $menuData = ['menu' => $this->filterMenu($menuArray['menu'] ?? [])];
        $currentRouteName = Route::currentRouteName();

        return view('components.menu', compact('menuData', 'currentRouteName'));
    }

    /**
     * @throws AuthenticationException
     */
    private function ensureAuthenticated(): void
    {
        if (! Auth::guard('manager')->check()) {
            throw new AuthenticationException();
        }

        $managerId = Auth::guard('manager')->id();
        $this->manager = $this->managerService->findById($managerId);
    }

    private function loadMenuData(): array
    {
        $menuPath = resource_path(self::MENU_PATH);

        if (! file_exists($menuPath)) {
            throw new RuntimeException("Menu file not found: {$menuPath}");
        }

        $content = file_get_contents($menuPath);

        if ($content === false) {
            throw new RuntimeException("Failed to read menu file: {$menuPath}");
        }

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Invalid JSON in menu file: ' . json_last_error_msg());
        }

        return $data;
    }

    protected function filterMenu(array $menu): array
    {
        return collect($menu)
            ->map(fn (array $item) => $this->processMenuItem($item))
            ->filter()
            ->values()
            ->toArray();
    }

    private function processMenuItem(array $item): ?array
    {
        if (! $this->hasPermissionForItem($item)) {
            return null;
        }

        if (! empty($item['submenu'])) {
            $item['submenu'] = $this->filterSubmenu($item['submenu']);

            if (empty($item['submenu'])) {
                return null;
            }
        }

        return $item;
    }

    private function filterSubmenu(array $submenu): array
    {
        return collect($submenu)
            ->filter(fn (array $subItem) => $this->hasPermissionForItem($subItem))
            ->values()
            ->toArray();
    }

    private function hasPermissionForItem(array $item): bool
    {
        if (empty($item['permission'])) {
            return true;
        }

        return $this->managerService->hasPermission($this->manager->id, $item['permission']);
    }
}