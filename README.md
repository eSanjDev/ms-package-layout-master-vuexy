# 🌟 Laravel Vuexy Master Layout Generator

A modular & extensible Laravel package for scaffolding a Vuexy-inspired admin layout.  
It includes views, assets, Blade components, menu management and alert handlers—all ready for you to start building your
admin panel faster and cleaner.

Built for Laravel 12.x, Vite, and supports dynamic nested menus, sectioned Blade structure, and permission-aware links
powered by 🛡️ esanj/managers.

---

## 🚀 Features

- 🎨 Pre-built Vuexy-based master layout
- 📦 Scaffolds views, sections, assets and components
- 🧩 Dynamic menu JSON with nested submenus & permissions
- 🔒 Permission-aware menus (via esanj/managers)
- 🎯 Ready for Laravel Vite setup
- 🧱 Supports custom JS/SCSS page parts

---

## 📦 Installation

Install the package via composer:

```bash
composer require esanj/layout-master
```

Then run the layout installer:

```bash
php artisan layout-master:install
```

☝️ This will publish all necessary assets, views, and structure into your Laravel project.

## 🛠 Folder Structure After Installation

### 📁 resources directory includes:

1. Views

```
   resources/views/
   ├── components/    # Blade reusable parts: alerts, menus, error...
   ├── layouts/
   │   └── master.blade.php
   ├── sections/      # Body sections like header, footer, loader, etc.
```

**You may customize or replace components freely.**

2. Assets

```
   resources/assets/
   ├── js/
   │   └── pages/       # Add your per-page JS here
   ├── scss/
   │   └── vendor/
   │       └── scss/pages/   # Add your custom SCSS pages here
```

Ensure you’re using Vite and not Mix.

## 🗂 Menu System

Menu is managed via dynamic JSON located at:

```
resources/menu/menu.json
```

* Nested menus / Submenus (∞ depth)
* Slug and permission-based visibility
* Badges and icons

### Example:

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
            "name": "Manager",
            "icon": "menu-icon icon-base ti tabler-Admins",
            "slug": "managers",
            "badge": [
                "primary",
                "3"
            ],
            "submenu": [
                {
                    "url": "/admin/managers/create",
                    "name": "Create New Manager",
                    "slug": "admin.managers.create",
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

#### ✨ The menu system supports:

* icon: Full CSS classes for icon
* target: set to "_blank" if you need external link
* permission: optional permission for menu visibility

## ⚙ Usage in Blade

Your pages should extend the provided layouts.master:

### Example:

```php
@extends('layouts.master')

@section('title', 'Dashboard')

@section('vendor-style')
   @vite([
     'resources/assets/vendor/libs/chartjs/chartjs.scss'
   ])
@endsection

@section('page-style')
   @vite([
     'resources/assets/vendor/scss/pages/dashboard.scss'
   ])
@endsection

@section('content')
   <div class="container">Welcome to the dashboard</div>
@endsection

@section('vendor-script')
   @vite([
     'resources/assets/vendor/libs/chartjs/chartjs.js'
   ])
@endsection

@section('page-script')
   @vite([
     'resources/assets/js/pages/dashboard.js'
   ])
@endsection
```

## 🧪 Building Assets
To compile your custom JS and SCSS:

```bash
vite build
```

**Use vite.config.js for further customization.**

## 🪪 License
**MIT © eSanjDev**
