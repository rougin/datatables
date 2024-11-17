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

use Rougin\Datatables\Request;
use Rougin\Datatables\Table;

// ...

// The $_GET variable should be returned ---
// and parsed as array<string, mixed> ------
$request = new Request($_GET);
// -----------------------------------------

// Parse columns based on the Request ---
$table = Table::fromRequest($request);
// --------------------------------------
```

By default, getting columns from the payload of the Javascript part of `DataTables` does not provide its name (e.g., `forename`, `surname`, etc.). As the column name is required for getting its data from a source, there is a need to map its column to the database table:

``` php
// index.php

// ...

$table->setName('users');

// The first column will be named as "forename" ---
$table->mapColumn(0, 'forename');
// ------------------------------------------------

$table->mapColumn(1, 'surname');
$table->mapColumn(2, 'position');
$table->mapColumn(3, 'office');
$table->mapColumn(4, 'date_start');
$table->mapColumn(5, 'salary');

// ...

```

Once the table has been properly configured, initialize a source (e.g., `PdoSource`) that will be used for getting the data of the specified table:

``` php
// index.php

use Rougin\Datatables\Source\PdoSource;

// ...

// Create a PDO instance... --------------
$dsn = 'mysql:host=localhost;dbname=demo';

$pdo = new PDO($dsn, 'root', /** ... */);
// ---------------------------------------

// ...then pass it to the PdoSource ---
$source = new PdoSource($pdo);
// ------------------------------------

// ...
```

Then use the `Query` class to generate the requested data: 

``` php
// index.php

use Rougin\Datatables\Query;

// ...

/** @var \Rougin\Datatables\Source\SourceInterface */
$source = /** ... */;

$query = new Query($request, $source);

/** @var \Rougin\Datatables\Result */
$result = $query->getResult($table);
```

The `getResult` from the `Query` class will return as the `Result` class in which returns the response as an array or as JSON format:

``` php
// index.php

// ...

/** @var \Rougin\Datatables\Result */
$result = $query->getResult($table);

echo $result->toJson();
```

``` bash
$ php index.php
```

``` json
{
  "draw": 1,
  "recordsFiltered": 57,
  "recordsTotal": 57,
  "data":
  [
    [
      "Airi",
      "Satou",
      "Accountant",
      "Tokyo",
      "2008-11-28",
      "162700.0"
    ],
    [
      "Angelica",
      "Ramos",
      "Chief Executive Officer (CEO)",
      "London",
      "2009-10-09",
      "1200000.0"
    ]
  ]
}
```

## Creating custom sources

To create a custom source, kindly use the `SourceInterface` for its implementation:

``` php
namespace Rougin\Datatables\Source;

use Rougin\Datatables\Request;
use Rougin\Datatables\Table;

interface SourceInterface
{
    /**
     * Returns the total items after filter.
     *
     * @return integer
     */
    public function getFiltered();

    /**
     * Returns the items from the source.
     *
     * @return string[][]
     */
    public function getItems();

    /**
     * Returns the total items from the source.
     *
     * @return integer
     */
    public function getTotal();

    /**
     * Sets the payload to be used in the source.
     *
     * @param \Rougin\Datatables\Request $request
     *
     * @return self
     */
    public function setRequest(Request $request);

    /**
     * Sets the table to be used in the source.
     *
     * @param \Rougin\Datatables\Table $table
     *
     * @return self
     */
    public function setTable(Table $table);
}
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