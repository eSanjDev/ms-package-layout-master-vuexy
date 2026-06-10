# 📚 Esanj Layout Master — Complete Beginner's Guide

This guide assumes **you have never used this package before**. It explains everything in plain language, step by
step, with copy‑paste commands. If you can run a few terminal commands and edit a Blade file, you can follow along.

> 💡 **What is this package?** It installs a ready‑made **admin panel skin** (the Vuexy layout) into your Laravel
> app: the page frame, the top navbar, the menu, the footer, and the build tooling. You then build your pages
> *inside* that frame. You don't design the layout — you fill it with content.

---

## Table of Contents

1. [How it works (the big picture)](#1-how-it-works-the-big-picture)
2. [Before you start: prerequisites](#2-before-you-start-prerequisites)
3. [Installation, step by step](#3-installation-step-by-step)
4. [What landed in your project](#4-what-landed-in-your-project)
5. [Building the front‑end assets](#5-building-the-front-end-assets)
6. [Recipe: add a new page](#6-recipe-add-a-new-page)
7. [Recipe: add the page to the menu](#7-recipe-add-the-page-to-the-menu)
8. [Recipe: nested submenus & badges](#8-recipe-nested-submenus--badges)
9. [Recipe: hide menu items by permission](#9-recipe-hide-menu-items-by-permission)
10. [Recipe: per‑page JS and SCSS](#10-recipe-per-page-js-and-scss)
11. [Recipe: show success/error alerts](#11-recipe-show-successerror-alerts)
12. [Recipe: show form validation errors](#12-recipe-show-form-validation-errors)
13. [Recipe: change the logo and brand name](#13-recipe-change-the-logo-and-brand-name)
14. [Recipe: change theme colors / default theme](#14-recipe-change-theme-colors--default-theme)
15. [The layout sections, explained](#15-the-layout-sections-explained)
16. [Components reference](#16-components-reference)
17. [Menu reference](#17-menu-reference)
18. [Troubleshooting](#18-troubleshooting)
19. [Cheat sheet](#19-cheat-sheet)

---

## 1. How it works (the big picture)

This package is a **scaffold**. When you install it, it **copies** a set of files into your project and then gets
out of the way. From then on, *you own those files* and edit them freely.

The pieces it gives you:

| Piece           | Where it lives after install                     | What it's for                                  |
|-----------------|--------------------------------------------------|------------------------------------------------|
| Master layout   | `resources/views/layouts/master.blade.php`       | The page frame every admin page extends.       |
| Sections        | `resources/views/sections/*.blade.php`           | Navbar, footer, `<head>`, scripts.             |
| Components       | `resources/views/components/*` + `app/View/Components/*` | Menu, submenu, alerts, field errors.    |
| Menu definition | `resources/menu/admin.json`                      | The links shown in the sidebar/topbar menu.    |
| Assets          | `resources/assets/*`                             | Your JS/SCSS (plus theme config).              |
| Build config    | `package.json`, `vite.config.js`, `postcss.config.js` | Tells Vite how to compile assets.        |
| Images          | `public/assets/vendor/layout-master/images/*`    | Logo & default avatar.                         |

**Mental model:** your page says *"use the master layout"* (`@extends('layouts.master')`) and fills in a few named
holes (`@section('content') ... @endsection`). The layout supplies everything around your content.

---

## 2. Before you start: prerequisites

This package is the **Vuexy layout glue**, not the entire Vuexy theme. Two things must be true:

1. **`esanj/managers` is set up and you can log in as a manager.** The menu and navbar assume an authenticated
   manager (the `manager` guard). If you open a page using this layout while logged out, the menu throws an
   authentication error.
2. **The Vuexy theme source assets exist** under `resources/assets/vendor/` (core SCSS, fonts, and JS libraries
   like Bootstrap, SweetAlert2, Select2…). This package references them but does **not** ship them. If your project
   doesn't have them yet, add them from your Vuexy purchase **before** running the asset build — otherwise Vite will
   error on missing files.

> If you only want to *see the Blade structure* without building assets, you can — but the page won't be styled
> until the assets are compiled.

---

## 3. Installation, step by step

**Step 1 — require the package:**

```bash
composer require esanj/layout-master
```

**Step 2 — run the installer:**

```bash
php artisan layout-master:install
```

If your project already has a `package.json`, `vite.config.js`, or `postcss.config.js`, the installer asks whether
to overwrite each one. Answer **no** to keep yours, **yes** to replace it with the package's version.

To skip all prompts and overwrite everything, use `--force`:

```bash
php artisan layout-master:install --force
```

> ℹ️ Re‑running **without** `--force` will **not** overwrite files you've already customized — it only fills in
> what's missing. Use `--force` when you deliberately want the package's originals back.

---

## 4. What landed in your project

After install you'll have (among others):

```
resources/
├── views/
│   ├── layouts/master.blade.php
│   ├── sections/         (head, navbar, footer, scripts)
│   └── components/       (menu, sub-menu, alert-message, error)
├── menu/
│   └── admin.json
└── assets/
    ├── css/demo.css
    ├── js/ (config.js, main.js, pages/BaseTable.js)
    └── scss/ (code-mirror*.scss)

app/View/Components/        (Menu.php, SubMenu.php)
public/assets/vendor/layout-master/images/  (logo-esanj.png, null.png)
package.json, vite.config.js, postcss.config.js   (project root)
```

Edit any of these freely — they're yours now. (Never edit the copies under `vendor/`; Composer overwrites those.)

---

## 5. Building the front‑end assets

The layout is styled by compiled CSS/JS. Build them with Vite:

```bash
npm install        # first time only — installs the theme's node packages
npm run dev        # development: watches & hot‑reloads
# or
npm run build      # production: one-off optimized build
```

`vite.config.js` automatically picks up:
- your page JS: `resources/assets/js/*.js` and `resources/assets/js/pages/*.js`
- the Vuexy `vendor/` and `packages/` trees.

> ⚠️ If `npm run dev/build` errors with *"file not found: resources/assets/vendor/..."*, you're missing the Vuexy
> theme assets — see [prerequisites](#2-before-you-start-prerequisites).

---

## 6. Recipe: add a new page

Let's add a **Reports** page at `/admin/reports`.

**Step 1 — create the Blade view** `resources/views/admin/reports.blade.php`:

```blade
@extends('layouts.master')

@section('title', 'Reports')

@section('content')
    <div class="container">
        <h4 class="py-3">Reports</h4>
        <div class="card">
            <div class="card-body">Your report content goes here.</div>
        </div>
    </div>
@endsection
```

**Step 2 — add a route** in `routes/web.php`. Give it a **name** — you'll reuse that name in the menu so the link
highlights when active:

```php
use Illuminate\Support\Facades\Route;

Route::middleware(['manager.auth:web'])->prefix('admin')->group(function () {
    Route::view('/reports', 'admin.reports')->name('admin.reports');
});
```

**Step 3 — visit `/admin/reports`** (while logged in as a manager). You'll see your content inside the full layout.

That's a complete page. Next, let's make it reachable from the menu.

---

## 7. Recipe: add the page to the menu

Open `resources/menu/admin.json` and add an item to the `menu` array:

```json
{
    "url": "/admin/reports",
    "name": "Reports",
    "icon": "menu-icon icon-base ti tabler-chart-bar",
    "slug": "admin.reports"
}
```

- `url` — where the link goes.
- `name` — the visible label (it's passed through `__()`, so a translation key works too).
- `icon` — full icon CSS classes (Tabler icons here).
- `slug` — set this to the **route name** you used in Step 2 (`admin.reports`). When that route is active, the menu
  item is highlighted automatically.

Reload any admin page — "Reports" now appears in the menu.

---

## 8. Recipe: nested submenus & badges

A parent item with no `url` but a `submenu` becomes an expandable group. Submenus can nest to any depth.

```json
{
    "name": "Catalog",
    "icon": "menu-icon icon-base ti tabler-package",
    "slug": "catalog",
    "badge": ["primary", "New"],
    "submenu": [
        {
            "name": "Products",
            "slug": "catalog.products",
            "submenu": [
                { "url": "/admin/products",        "name": "All Products", "slug": "catalog.products.index" },
                { "url": "/admin/products/create", "name": "Add Product",  "slug": "catalog.products.create" }
            ]
        },
        { "url": "/admin/categories", "name": "Categories", "slug": "catalog.categories" }
    ]
}
```

- `badge`: `["color", "text"]` → a small pill, e.g. `["primary", "New"]` or `["danger", "5"]`.
- Nest `submenu` inside `submenu` for deeper levels.

---

## 9. Recipe: hide menu items by permission

Add a `permission` key to any item. The item is shown only if the logged‑in manager has that permission (checked
through `esanj/managers`). Admins see everything.

```json
{
    "url": "/admin/managers",
    "name": "Managers List",
    "slug": "managers.index",
    "permission": "managers.list"
}
```

- No `permission` → always visible (to authenticated managers).
- A parent group whose children are **all** hidden becomes hidden too — no empty groups.

> The permission strings (e.g. `managers.list`) come from `esanj/managers`. Define and import them there.

---

## 10. Recipe: per‑page JS and SCSS

Keep each page's scripts/styles in their own files; Vite compiles them automatically.

**JavaScript:** create `resources/assets/js/pages/reports.js` (the `js/pages/*.js` glob picks it up), then load it
in your page:

```blade
@section('page-script')
    @vite(['resources/assets/js/pages/reports.js'])
@endsection
```

**SCSS:** put page styles under the Vuexy pages folder `resources/assets/vendor/scss/pages/reports.scss`, then:

```blade
@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/reports.scss'])
@endsection
```

Use `@section('vendor-script')` / `@section('vendor-style')` the same way for third‑party libraries (charts,
pickers, …).

---

## 11. Recipe: show success/error alerts

The layout automatically renders an alert when you flash a `message` from your controller:

```php
return back()->with('message', [
    'type'    => 'success',          // success | danger | warning | info | primary | secondary | dark
    'content' => 'Saved successfully!',
]);
```

Or drop an alert anywhere yourself:

```blade
<x-alert-message :type="'warning'" :content="'Heads up — check your input.'" :dismissible="true" />
```

---

## 12. Recipe: show form validation errors

Use the `<x-error>` component next to any field to display its validation message (and array‑field errors like
`items.*`):

```blade
<input name="email" class="form-control" value="{{ old('email') }}">
<x-error field="email" />
```

---

## 13. Recipe: change the logo and brand name

**Logo:** the navbar shows `public/assets/vendor/layout-master/images/logo-esanj.png`. Either:
- replace that PNG with your own (same name), **or**
- edit the `<img src="...">` in `resources/views/sections/navbar.blade.php`.

**Brand name** (used in the page `<title>`): the layout prints `trans('app.brand_name')`. Create/edit
`lang/en/app.php` (and other locales):

```php
return ['brand_name' => 'My Admin'];
```

---

## 14. Recipe: change theme colors / default theme

Open `resources/assets/js/config.js`:

```js
window.templateCustomizer = new TemplateCustomizer({
    defaultPrimaryColor: '#2ABB9C',   // ← your brand color
    defaultTheme: 'light',            // 'light' | 'dark' | 'system'
    defaultTextDir: 'ltr',            // 'ltr' | 'rtl'
    // ...
});
```

Rebuild assets (`npm run dev`/`build`) and **clear your browser local storage** to see theme changes (the theme
remembers your last choice there).

---

## 15. The layout sections, explained

Your pages extend `layouts.master` and may fill these named holes:

| Section          | Where it renders        | Use it for                                  |
|------------------|-------------------------|---------------------------------------------|
| `title`          | `<title>` tag           | The page title.                             |
| `vendor-style`   | `<head>`, after core CSS| Third‑party library CSS.                    |
| `page-style`     | `<head>`, after core CSS| This page's own CSS.                        |
| `content`        | Main content area       | Your page body.                             |
| `vendor-script`  | Before theme JS         | Third‑party library JS.                     |
| `page-script`    | After theme JS          | This page's own JS.                         |

The navbar, menu (`<x-menu>`), and footer are included by the layout automatically — you don't add them per page.

---

## 16. Components reference

| Component                                                          | Props                                                            |
|--------------------------------------------------------------------|-----------------------------------------------------------------|
| `<x-menu />`                                                       | none — reads `resources/menu/admin.json` and filters by permission. |
| `<x-sub-menu :data="$items" />`                                   | `data`: array of submenu items (used internally).               |
| `<x-alert-message />`                                              | `type` (default `info`), `content`, `dismissible` (default `true`), `additionalClass`. |
| `<x-error />`                                                      | `field`: the input name to show errors for.                     |

> The `Menu`/`SubMenu` PHP classes live in `app/View/Components/` after install, so they're regular app components.

---

## 17. Menu reference

File: `resources/menu/admin.json`, shape `{ "menu": [ ...items ] }`.

| Field        | Type     | Notes                                                               |
|--------------|----------|---------------------------------------------------------------------|
| `name`       | string   | Label; passed through `__()`.                                       |
| `url`        | string   | Link; `url()` applied. Omit for a submenu‑only parent.              |
| `icon`       | string   | Full icon CSS classes.                                              |
| `slug`       | string   | Compared to the current route name to set the active state.        |
| `permission` | string   | Optional; item shown only if the manager has it.                   |
| `target`     | string   | e.g. `"_blank"`.                                                    |
| `badge`      | array    | `["color", "text"]`.                                                |
| `submenu`    | array    | Child items; nestable to any depth.                                |

---

## 18. Troubleshooting

**`npm run dev/build` fails: "Could not resolve resources/assets/vendor/...".**
The Vuexy theme assets aren't in your project. Add the `resources/assets/vendor/` tree from your Vuexy purchase,
then rebuild. (See [prerequisites](#2-before-you-start-prerequisites).)

**The page loads but is completely unstyled.**
Assets aren't built or aren't being served. Run `npm run dev` (and keep it running) or `npm run build`, and make
sure your Blade includes `@vite` via the master layout (it does by default).

**"Unauthenticated" / an exception from the menu.**
The layout requires a logged‑in manager. Log in via `esanj/managers` first, and protect your admin routes with the
`manager.auth:web` middleware.

**A menu item doesn't appear.**
Either it has a `permission` the current manager lacks, or (for a group) all its children are hidden. Remove the
permission to test, or grant it.

**The active highlight doesn't work.**
The item's `slug` must equal the **route name** of the current page. Check `php artisan route:list` for the exact
name and match it in `admin.json`.

**My customized files got overwritten.**
You probably ran `layout-master:install --force`. Without `--force`, existing files are preserved. Keep your edits
in the published files and avoid `--force` unless you want the originals back.

**The title shows `app.brand_name` literally.**
Define `brand_name` in `lang/{locale}/app.php` (see [recipe 13](#13-recipe-change-the-logo-and-brand-name)).

---

## 19. Cheat sheet

```bash
# Install
composer require esanj/layout-master
php artisan layout-master:install        # add --force to overwrite everything

# Build assets
npm install
npm run dev          # watch / hot-reload
npm run build        # production build

# Publish a single part
php artisan vendor:publish --tag=esanj-layout-master-views
php artisan vendor:publish --tag=esanj-layout-master-menu
```

```blade
{{-- A page --}}
@extends('layouts.master')
@section('title', 'My Page')
@section('content') ... @endsection
@section('page-script') @vite(['resources/assets/js/pages/my-page.js']) @endsection
```

| I want to...                  | Do this                                                          |
|-------------------------------|------------------------------------------------------------------|
| Add a page                    | Blade `@extends('layouts.master')` + a named route               |
| Add a menu link               | add an item to `resources/menu/admin.json` (`slug` = route name) |
| Group links                   | a parent item with a `submenu` array                             |
| Hide a link by permission     | add `"permission": "..."` to the item                            |
| Flash a success/error alert   | `->with('message', ['type' => '...', 'content' => '...'])`        |
| Show field errors             | `<x-error field="email" />`                                      |
| Change the logo               | replace `public/assets/vendor/layout-master/images/logo-esanj.png` |
| Change brand name             | `brand_name` in `lang/{locale}/app.php`                          |
| Change theme color            | `defaultPrimaryColor` in `resources/assets/js/config.js`         |

---

Need the quick reference instead? See the [README](../README.md).