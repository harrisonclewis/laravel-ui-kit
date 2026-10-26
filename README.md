# Laravel UI Kit

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-ui-kit/laravel-ui-kit.svg?style=flat-square)](https://packagist.org/packages/laravel-ui-kit/laravel-ui-kit)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-ui-kit/laravel-ui-kit.svg?style=flat-square)](https://packagist.org/packages/laravel-ui-kit/laravel-ui-kit)
![GitHub Actions](https://github.com/laravel-ui-kit/laravel-ui-kit/actions/workflows/main.yml/badge.svg)

Laravel UI Kit is a comprehensive set of view components for Laravel built using Livewire and Blade.

## Installation

### Install Laravel UI Kit

You can install Laravel UI Kit via Composer. Run the following command:

```bash
composer require laravel-ui-kit/laravel-ui-kit
```

### Supported versions

| Dependency | Supported versions |
| --- | --- |
| PHP | 8.2+ (Laravel 13 requires 8.3+) |
| Laravel | 10, 11, 12, 13 |
| Tailwind CSS | 3.4, 4.x |
| Alpine.js | 3.x (bundled with Livewire 3 and 4) |
| Livewire (optional) | 3.x, 4.x |

Laravel 10 and 11 are retained for legacy compatibility. Use Laravel 12 or 13 for new applications.

The components are Blade views. Livewire is only needed when you use `wire:*` bindings.
Laravel discovers the service provider automatically.

### Install Tailwind CSS 4

Follow the [Tailwind CSS Laravel/Vite installation guide](https://tailwindcss.com/docs/installation/framework-guides/laravel/vite).
In `resources/css/app.css`, register the package configuration and views explicitly because Tailwind does not scan vendor files by default:

```css
@import "tailwindcss";

@source "../../vendor/laravel-ui-kit/laravel-ui-kit/config/**/*.php";
@source "../../vendor/laravel-ui-kit/laravel-ui-kit/resources/views/**/*.blade.php";
@source "../../config/ui-kit.php";
@source "../../config/ui-kit/**/*.php";
@source "../views/**/*.blade.php";

/* Include this if your application toggles dark mode with a .dark class. */
@custom-variant dark (&:where(.dark, .dark *));
```

Paths are relative to `resources/css/app.css`. Both the configuration files and Blade
views contain utility classes and must be scanned, including published overrides.

For styled checkboxes, radio buttons, and select controls, install the
[Tailwind forms plugin](https://github.com/tailwindlabs/tailwindcss-forms):

```bash
npm install -D @tailwindcss/forms
```

```css
@plugin "@tailwindcss/forms";
```

### Tailwind CSS 3.4

Existing applications can keep Tailwind CSS 3.4. Include these paths in `tailwind.config.js`:

```javascript
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './config/ui-kit.php',
        './config/ui-kit/**/*.php',
        './vendor/laravel-ui-kit/laravel-ui-kit/config/**/*.php',
        './vendor/laravel-ui-kit/laravel-ui-kit/resources/views/**/*.blade.php',
    ],
    // Add @tailwindcss/forms to your plugins if styling form controls.
};
```

### Alpine.js and Livewire

Interactive components use Alpine.js 3. Livewire 3 and 4 already include Alpine;
do not load a second copy. For Blade-only applications, follow the
[Alpine.js installation guide](https://alpinejs.dev/essentials/installation).

Attributes such as `wire:model.live`, `wire:click`, and `wire:loading` are forwarded
to the underlying form controls and buttons:

```blade
<x-input wire:model.live="name" />
<x-button wire:click="save" wire:loading.attr="disabled">Save</x-button>
```

### Publishing configuration and views

```bash
php artisan vendor:publish --provider="LaravelUiKit\LaravelUiKitServiceProvider" --tag=config
php artisan vendor:publish --provider="LaravelUiKit\LaravelUiKitServiceProvider" --tag=views
```

The configuration includes `config/ui-kit.php` and the `config/ui-kit/` directory.
When upgrading an application with published configuration or views, merge the package
changes into those overrides. Replace removed Tailwind utilities such as `bg-opacity-50`
with color opacity modifiers such as `bg-zinc-500/50`, and `flex-grow` / `flex-shrink-0`
with `grow` / `shrink-0`. See the [Tailwind CSS upgrade guide](https://tailwindcss.com/docs/upgrade-guide)
for other application-level changes.

## Usage

For usage and examples, please visit our documentation:

[Laravel UI Kit](https://laravel-ui-kit.com)

### Testing

```bash
composer install
composer test
```

Tests cover component rendering, configuration publishing, class merging, form method
spoofing, and Livewire state updates. GitHub Actions tests Laravel 10–13 with the
matching Orchestra Testbench and PHPUnit versions, including Livewire 3 and 4.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email harrison@harlew.com instead of using the issue tracker.

## Credits

- [Harlew.com](https://harlew.com)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
