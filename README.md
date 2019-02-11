# Datatables

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Datatables is a package that uses [Doctrine](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest) or [Eloquent](https://laravel.com/docs/master/eloquent) to generate a [server-side AJAX result](https://datatables.net/examples/data_sources/server_side.html) to a [Datatable](https://datatables.net/) instance.

## Installation

Install `Datatables` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/datatables
```

## Basic Usage

### Doctrine

``` php
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Rougin\Datatables\Builder\DoctrineBuilder;
use Rougin\Datatables\Message\RequestFactory;
use Rougin\Datatables\Message\ResponseFactory;

$config = new Configuration;
$database = array('charset' => 'utf8');
$database['driver'] = 'pdo_mysql';
$database['user'] = 'root';
$database['pass'] = '';
$database['dbname'] = 'test';
$database['host'] = 'localhost';
$connection = DriverManager::getConnection($database, $config);
$builder = new DoctrineBuilder($connection->createQueryBuilder());

$request = RequestFactory::http($_GET);

$builder->factory(new ResponseFactory);

$builder->table('users');

$response = $builder->build($request);

echo json_encode($response->result());
```

### Eloquent

Coming soon.

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Credits

- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/datatables.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/datatables.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/datatables.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/datatables/master.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/datatables.svg?style=flat-square

[link-changelog]: https://github.com/rougin/datatables/blob/master/CHANGELOG.md
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/datatables
[link-contributors]: https://github.com/rougin/datatables/contributors
[link-downloads]: https://packagist.org/packages/rougin/datatables
[link-license]: https://github.com/rougin/datatables/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/datatables
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/datatables/code-structure
[link-travis]: https://travis-ci.org/rougin/datatables