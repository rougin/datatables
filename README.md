# Datatables

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Use [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest) or [Eloquent](https://laravel.com/docs/master/eloquent) for [Datatables](https://datatables.net/)' [server-side processing](https://datatables.net/examples/data_sources/server_side.html).

## Install

Via Composer

``` bash
$ composer require rougin/datatables
```

## Usage

### DoctrineBuilder

``` php
use Rougin\Datatables\DoctrineBuilder;

// $manager variable must return an EntityManager instance.
// See "tests/DoctrineBuilderTest.php" for sample code.

$entity = 'Acme\Doctrine\Models\User';

$builder = new DoctrineBuilder($manager, $entity, $_GET);

header('Content-Type: application/json');

echo json_encode($builder->make());
```

**NOTE**: `$manager` must return an instance of `Doctrine\ORM\EntityManager`. See [DoctrineBuilderTest::setUp](tests/DoctrineBuilderTest.php#L26) for the sample implementation.

### EloquentBuilder

``` php
use Rougin\Datatables\EloquentBuilder;

$model = 'Acme\Eloquent\Models\UserModel';

$builder = new EloquentBuilder($model, $_GET);

header('Content-Type: application/json');

echo json_encode($builder->make());
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer require doctrine/orm illuminate/database --dev
$ composer test
```

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