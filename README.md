# OpenApi Documentation Generator
Generates and validate your OpenAPI documentation.
Build up your your open api documentation in a way that you're familiar with, PHP Arrays.
Instead of making a static documentation for all your modules that is always shown, you can use this generator to only generate the docs based on the modules you have installed at the moment.

When installing a new module you can generate the documentation again to inject that modules documentation to the bigger thing.


Also - it ships with [Redoc](https://redocly.github.io/redoc/) ([Github](https://github.com/Redocly/redoc)) so your clients can have a beatiful UI to look at when integrating to your API.

## Installation

You can install the package via composer:

```bash
composer require rockymontana/oa-documentor (soon)
```

## Usage

``` bash
php artisan openapi:generate
```


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email jonas@webbish.se instead of using the issue tracker.

## Credits

- [Jonas Erlandsson](https://github.com/rockymontana)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
