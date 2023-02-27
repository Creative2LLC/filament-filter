# Filament Filter

Filament Filter is a Laravel package that provides a simple and elegant way to add filters to your Filament admin panel. With Filament Filter, you can easily create filters that allow your users to search, sort, and filter your data based on specific criteria. 

## Installation

You can install the package via composer:

```bash
composer require creative2llc/filament-filter
```

## Usage

To add the filter to your Filament Resource, navigate to the `ListRecords` class you are extending, and include the 'HasFilamentFilter' trait. Also make sure to include the `getColumnsProperty()` method, which will return an array of columns that you want to be searchable. The key of the array will be the database column name, and the value will be the user facing column name.

```php

class ListPosts extends ListRecords
{

    use HasFilamentFilter;

    protected static string $resource = Post::class;

    public function getColumnsProperty(): array
    {
        return [
            'database_column' => 'User Facing Column Name',
        ];
    }

}

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

- [Sam Miller](https://github.com/arrgh11)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
