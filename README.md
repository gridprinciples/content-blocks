# Content Blocks for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gridprinciples/content-blocks.svg?style=flat-square)](https://packagist.org/packages/gridprinciples/content-blocks)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/gridprinciples/content-blocks/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/gridprinciples/content-blocks/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/gridprinciples/content-blocks/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/gridprinciples/content-blocks/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/gridprinciples/content-blocks.svg?style=flat-square)](https://packagist.org/packages/gridprinciples/content-blocks)

This package is under ongoing development.

## Installation

You can install the package via composer:

```bash
composer require gridprinciples/content-blocks
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="content-blocks-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="content-blocks-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="content-blocks-views"
```

## Usage

```php
$contentBlocks = new GridPrinciples\ContentBlocks();
echo $contentBlocks->echoPhrase('Hello, GridPrinciples!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Greg Brock](https://github.com/gbrock)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
