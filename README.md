# Datatables

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

`Datatables` is a simple PHP package that handles the [server-side of DataTables](https://datatables.net/examples/data_sources/server_side.html). Its server-side response can be used by `DataTables` from the HTML which requires little to no configuration.

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

``` html
<!-- index.html -->

<!-- ... -->

<table id="example"></table>
```

> [!NOTE]
> For more information in the above example, kindly see the [official guide](https://datatables.net/examples/data_sources/server_side.html) on how to implement server-side rendering of data to `DataTables`.

From the PHP part, use the `Table` class to define the specified table:

``` php
// index.php

use Rougin\Datatables\Config;
use Rougin\Datatables\Table;

// ...

// The $_GET variable should be returned ---
// and parsed as array<string, mixed> ------
$config = new Config($_GET);
// -----------------------------------------

// Parse columns based on the Config ---
$table = Table::fromConfig($config);
// -------------------------------------
```

By default, getting columns from the payload of the Javascript part of `DataTables` does provide its name. As the column name is required for getting its data from a source, there is a need to map its column to the database table:

``` php
// index.php

// ...

$table->mapColumn(0, 'forename');
$table->mapColumn(1, 'surname');
$table->mapColumn(2, 'position');
$table->mapColumn(3, 'office');
$table->mapColumn(4, 'date_start');
$table->mapColumn(5, 'salary');

// ...

```

Once the table has been properly configured, use the `Query` class and the `Config` class to generate the requested data to the table: 

``` php
// index.php

use Rougin\Datatables\Config;
use Rougin\Datatables\Query;

// ...

// Parse the data from the query params ---
$config = new Config($params);
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

``` bash
$ php index.php
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

use Acme\Sources\ModelSource;
use Acme\Models\User;
use Rougin\Datatables\Source;

// ...

/** @var \Rougin\Datatables\Query */
$query = /** ... */;

/** @var \Rougin\Datatables\Source\SourceInterface */
$source = new ModelSource(new User);

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