# 🌟 Esanj Layout Master (Vuexy)

A Laravel **scaffolding** package that drops a ready‑made, Vuexy‑inspired admin layout into your app: a master
Blade layout, header/menu/footer sections, reusable components, a permission‑aware dynamic menu, and the Vite/SCSS
build configuration.

Everything is **published into your project** so you fully own and can customize it. The package itself only ships
the files and one install command — it registers no routes or runtime views.

**Supports:** Laravel 10 · 11 · 12 · 13 — PHP 8.2+

---

## ✨ Features

- 🎨 Pre‑built Vuexy master layout with header, horizontal menu, and footer.
- 🧩 Dynamic **JSON menu** with unlimited nested submenus, icons, badges, and per‑item permissions.
- 🔒 Permission‑aware menu links powered by **`esanj/managers`**.
- 🧱 Reusable Blade components: `<x-menu>`, `<x-sub-menu>`, `<x-alert-message>`, `<x-error>`.
- ⚡ Vite + SCSS build config, with auto‑discovered per‑page JS/SCSS.

---

## ⚠️ Important: this is a Vuexy *scaffold*, not the full theme

This package provides the **layout, components, menu, and build config** — plus a handful of source assets
(`config.js`, `main.js`, `demo.css`, CodeMirror SCSS). It does **not** bundle the full Vuexy theme source.

The published `head`/`scripts` sections and `vite.config.js` reference the Vuexy theme tree at
`resources/assets/vendor/...` (core SCSS, fonts, and JS libs like Bootstrap, SweetAlert2, Select2, …). **You must
supply that `resources/assets/vendor/` tree yourself** (from your Vuexy purchase). Without it, `npm run build`/`dev`
will fail on missing files.

> In short: install this package **into a project that already has the Vuexy assets**, or add them before building.

---

## 📋 Requirements

- PHP 8.2+
- Laravel 10–13
- **`esanj/managers`** (installed automatically) — the layout assumes an authenticated **manager** (`manager` guard)
  and uses its permissions for menu visibility and the logout route.
- Node.js + npm (for the Vite asset build).

---

## 📦 Installation

```bash
composer require esanj/layout-master
php artisan layout-master:install
```

The installer asks before overwriting any existing `package.json` / `vite.config.js` / `postcss.config.js`, then
publishes everything. Use `--force` to overwrite without prompts:

```bash
php artisan layout-master:install --force
```

Then build the front‑end:

```bash
npm install
npm run dev      # or: npm run build
```

---

## 🗂️ What gets published

| Publish tag                        | From (package)        | To (your app)                          | Contents                                    |
|------------------------------------|-----------------------|----------------------------------------|---------------------------------------------|
| `esanj-layout-master-views`        | `resources/views`     | `resources/views`                      | `layouts/master`, `sections/*`, `components/*` |
| `esanj-layout-master-menu`         | `resources/menu`      | `resources/menu`                       | `admin.json` (the menu definition)          |
| `esanj-layout-master-assets`       | `resources/assets`    | `resources/assets`                     | `css/demo.css`, `js/*`, `scss/*`            |
| `esanj-layout-master-public`       | `public`              | `public/assets/vendor/layout-master`   | `images/logo-esanj.png`, `images/null.png`  |
| `esanj-layout-master-static`       | `static`              | project root                           | `package.json`, `vite.config.js`, `postcss.config.js` |
| `esanj-layout-master-components`   | `Components`          | `app/View/Components`                   | `Menu.php`, `SubMenu.php`                    |

`layout-master:install` publishes all of these at once. You can also publish a single group:

```bash
php artisan vendor:publish --tag=esanj-layout-master-views
```

---

## ⚙️ Using the layout

Make your pages extend `layouts.master` and fill in the sections:

```blade
@extends('layouts.master')

@section('title', 'Dashboard')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/dashboard.scss'])
@endsection

@section('content')
    <div class="container">Welcome to the dashboard</div>
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/pages/dashboard.js'])
@endsection
```

Available sections: `title`, `vendor-style`, `page-style`, `content`, `vendor-script`, `page-script`.
The navbar, menu, and footer are included for you.

> The page `<title>` is `@yield('title') | {{ trans('app.brand_name') }}`, so define `brand_name` in your app's
> `lang/{locale}/app.php` (or change the title in `resources/views/layouts/master.blade.php`).

---

## 🗂️ The menu system

The menu is a JSON file at **`resources/menu/admin.json`** with a top‑level `menu` array:

```json
{
    "menu": [
        {
            "url": "/admin",
            "name": "Dashboard",
            "icon": "menu-icon icon-base ti tabler-smart-home",
            "slug": "admin.dashboard"
        },
        {
            "name": "Managers",
            "icon": "menu-icon icon-base ti tabler-users",
            "slug": "managers",
            "badge": ["primary", "3"],
            "submenu": [
                {
                    "url": "/admin/managers/create",
                    "name": "Create New Manager",
                    "slug": "managers.create",
                    "permission": "managers.create"
                },
                {
                    "url": "/admin/managers",
                    "name": "Managers List",
                    "slug": "managers.index",
                    "permission": "managers.list"
                }
            ]
        }
    ]
}
```

Item fields:

| Field        | Required | Purpose                                                                              |
|--------------|----------|--------------------------------------------------------------------------------------|
| `name`       | yes      | Label. Passed through `__()`, so it can be a translation key.                       |
| `url`        | no       | Link target (`url()` is applied). Omit for a parent that only opens a submenu.      |
| `icon`       | no       | Full CSS classes for the icon.                                                       |
| `slug`       | no       | Matched against the **current route name** to mark the item active.                 |
| `permission` | no       | If set, the item shows only when the manager has this permission (`esanj/managers`). |
| `target`     | no       | e.g. `"_blank"` for external links.                                                  |
| `badge`      | no       | `["color", "text"]`, e.g. `["primary", "3"]`.                                       |
| `submenu`    | no       | Array of child items (nested to any depth).                                          |

> 🔒 The menu requires an authenticated manager. A parent whose children are **all** hidden by permissions is
> hidden too.

---

## 🧩 Components

After publishing, these components are available in any Blade view:

| Component                                                            | Purpose                                            |
|---------------------------------------------------------------------|----------------------------------------------------|
| `<x-menu />`                                                        | Renders the permission‑filtered main menu.         |
| `<x-sub-menu :data="$items" />`                                    | Renders a submenu (used internally by `<x-menu>`). |
| `<x-alert-message :type="'success'" :content="'Saved!'" />`        | A Bootstrap alert. Types: success/danger/warning/info/primary/secondary/dark. |
| `<x-error field="email" />`                                        | Shows validation errors for a field (and `field.*`). |

The master layout also renders a **flash alert** automatically when you flash a `message`:

```php
return back()->with('message', ['type' => 'success', 'content' => 'Saved successfully!']);
```

---

## 🎨 Customizing

- **Views/sections:** edit the published files in `resources/views/` (e.g. `sections/navbar.blade.php`,
  `layouts/master.blade.php`).
- **Logo:** replace `public/assets/vendor/layout-master/images/logo-esanj.png`, or edit the path in
  `sections/navbar.blade.php`.
- **Theme defaults** (primary color, default theme, RTL, …): `resources/assets/js/config.js`.
- **Menu:** edit `resources/menu/admin.json`.
- **Build inputs:** `vite.config.js` (auto‑includes `resources/assets/js/*`, `js/pages/*`, and the Vuexy
  `vendor/`, `packages/` trees).

> 📖 For a complete, beginner‑friendly, step‑by‑step walkthrough — adding a page, wiring a menu item, building
> assets, and customizing — see **[docs/GUIDE.md](docs/GUIDE.md)**.

---

## 🪪 License

MIT © eSanjDev