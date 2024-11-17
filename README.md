# Datatables

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

`Datatables` is a simple that handles the [server-side of DataTables](https://datatables.net/examples/data_sources/server_side.html). Its server-side response can be used by `DataTables` from the HTML with little to no configuration required.

## Installation

Install the `Datatables` package via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/datatables
```

## Basic usage

Prior in configuring `Datatables`, kindly ensure that the `serverSide` property is set to `true` in the Javascript part:

``` js
// index.js

let options = { processing: true }

options.ajax = 'http://localhost:8000'

options.serverSide = true

new DataTable('#example', options)
```

> [!NOTE]
> For more information in the above example, kindly see the [official guide](https://datatables.net/examples/data_sources/server_side.html) on how to implement server-side rendering of data to `DataTables`.

From the PHP part, use the `Table` class to define the specified table:

``` php
// index.php

use Rougin\Datatables\Table;

// ...

$table = new Table;

$table->newColumn('id', 'ID');
$table->newColumn('email', 'Email');
$table->newColumn('name', 'Name');
```

Once the `Table` class has been properly defined, use the `Query` class and the `Config` class to generate the requested data to the table: 

``` php
// index.php

use Rougin\Datatables\Config;
use Rougin\Datatables\Query;

// ...

// Parse the data from the query params ---
$config = new Config($_GET);
// ----------------------------------------

$query = new Query($config);

/** @var \Rougin\Datatables\Result */
$result = $query->getResult($table);
```

Once the parsed from `Query`, it will be returned as `Result` class in which returns the response as an array or as JSON:

``` php
// index.php

// ...

/** @var \Rougin\Datatables\Result */
$result = $query->parse($table);

echo $result->toJson();
```

``` json
{
  "draw": 2,
  "recordsFiltered": 0,
  "recordsTotal": 0,
  "data": []
}
```

To provide data from a specified source (e.g., from database), kindly use the `setSource` method from the `Query` class:

``` php
// index.php

use Acme\Depots\UserDepot;
use Acme\Models\User;
use Rougin\Datatables\Source;

// ...

/** @var \Rougin\Datatables\Query */
$query = /** ... */;

/** @var \Rougin\Datatables\Source\SourceInterface */
$source = new UserDepot;

$source->setModel(new User);

$query->setSource($source);

// ...
```

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

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/datatables/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/datatables?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/datatables.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/datatables.svg?style=flat-square

[link-build]: https://github.com/rougin/datatables/actions
[link-changelog]: https://github.com/rougin/datatables/blob/master/CHANGELOG.md
[link-contributors]: https://github.com/rougin/datatables/contributors
[link-coverage]: https://app.codecov.io/gh/rougin/datatables
[link-downloads]: https://packagist.org/packages/rougin/datatables
[link-license]: https://github.com/rougin/datatables/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/datatables