## Installation

You can install the package via composer:

```bash
composer require oh-my-cod3/people-manager
```

## Set up

Create tables (people and planets):

```bash
php artisan migrate
```

## Usage

```php
php artisan pm:import
```

## API

GET: /api/people
GET: /api/people/{person_id}

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ohmycode@nomail.com instead of using the issue tracker.

## Credits

-   [Ohmycode](https://github.com/oh-my-cod3)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
