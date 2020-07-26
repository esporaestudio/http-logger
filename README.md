# Http Logger

## Introduction

This is a package that can be used for logging in the database the requests made on a route. The purpose of this package is to enable visibility on the development and debugging process.

### Use with caution

Consider that logging the requests may produce results that you don't want such as:

* Logging sensitive information like passwords, emails, names, ips, etcetera.
* Increasing the size of the database.
* Slowing the performance of your app.

Please consider using this package with caution, mainly just for dev and debugging.

## Installation

### Requirements

This package hasn't been published on packagist since it doesn't contains Unit Testing. For now the installation it's a bit "manual".

On your `composer.json` add the repository of the package

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/esporaestudio/http-logger.git"
    }
],
```

### Steps

1. Run the command:

```bash
composer require espora/http-logger
```

2. Publish the migrations:
```bash
php artisan vendor:publish --provider="Espora\HttpLogger\HttpLoggerServiceProvider" --tag="migrations"
```

## Usage

The logger can be used through the middleware `log-request`, for example:

```php
Route::get('/', function () {
    return view('welcome');
})->middleware('log-request');
```

## Options

### Configuration

If you want to disable the logging you can use environment variable of `ESPORA_HTTP_LOGGER`. If the variable it's set to false then it won't log the requests were the middleware it's being use.

### Purging the table

If you want to purge (truncate) the table (http_logs) execute:

```bash
php artisan espora:http-logger:purge
```
