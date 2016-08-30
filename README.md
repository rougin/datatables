# Datatables

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Handles DataTables' [server-side processing](https://datatables.net/examples/data_sources/server_side.html) using [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest) or [Eloquent](https://laravel.com/docs/master/eloquent).

## Install

Via Composer

``` bash
$ composer require rougin/datatables
```

## Usage

### Doctrine

[example/ajax.php](example/ajax.php)

``` php
$entity  = Rougin\Datatables\Test\User\DoctrineModel::class;
$builder = new Rougin\Datatables\DoctrineBuilder($entity, $entityManager, $_GET);

header('Content-Type: application/json');

echo json_encode($builder->make());
```

### Eloquent

[example/ajax.php](example/ajax.php)

``` php
$model   = Rougin\Datatables\Test\User\EloquentModel::class;
$builder = new Rougin\Datatables\EloquentBuilder($model, $_GET);

header('Content-Type: application/json');

echo json_encode($builder->make());
```

You can also try the demo in [example](example) directory.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email rougingutib@gmail.com instead of using the issue tracker.

## Credits

- [Rougin Royce Gutib][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rougin/datatables.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/datatables/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/datatables.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/datatables.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/datatables.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rougin/datatables
[link-travis]: https://travis-ci.org/rougin/datatables
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/datatables/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/datatables
[link-downloads]: https://packagist.org/packages/rougin/datatables
[link-author]: https://github.com/rougin
[link-contributors]: ../../contributors
