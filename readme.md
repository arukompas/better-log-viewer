[![Packagist](https://img.shields.io/packagist/v/arukompas/better-log-viewer.svg)](https://packagist.org/packages/arukompas/better-log-viewer)
[![Packagist](https://img.shields.io/packagist/dm/arukompas/better-log-viewer.svg)](https://packagist.org/packages/arukompas/better-log-viewer)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/arukompas/better-log-viewer.svg)](https://packagist.org/packages/arukompas/better-log-viewer)
[![Laravel Version](https://img.shields.io/badge/Laravel-5.x,%206.x,%207.x,%208.x-brightgreen.svg)](https://packagist.org/packages/arukompas/better-log-viewer)


# Better Log Viewer

Better Log Viewer is a Laravel package for viewing your Laravel logs in a clean and intuitive web interface.

**Supports all Laravel 5, Laravel 6, Laravel 7 and Laravel 8 versions.**


![Better Log Viewer](better-log-viewer.png)


## Installation

### 1. Require the package

```
composer require arukompas/better-log-viewer
```

### 2. (Laravel 5.4 and older only) - Provider

Add the service provider to your `config/app.php` configuration's `'providers'` array:

```
Arukompas\BetterLogViewer\BetterLogViewerProvider::class,
```

### 3. (optional) Publish the config

You can publish the config using this artisan command:
```
php artisan vendor:publish --tag=config
```

### 4. Visit `<your-app-url>/log-viewer`

## Configuration

You can configure the middleware and the route for the log viewer in the `config/better-log-viewer.php` file which was previously copied over by the vendor publish command.
