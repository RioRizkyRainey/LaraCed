# LaraCed (Laravel Creator-Editor-Destroyer)

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package automatically inserts/updates creator, editor and destroyer on your table.

## Requirements

* This package requires PHP 7.1+
* It works with Laravel 5.5 (and may work with earlier versions too).

## Install via Composer

```bash
composer require riorizkyrainey/lara-ced
```

## Usage

Update your model's migration and add `created_by`, `updated_by` and `deleted_by` field using the `ced()` blueprint macro.

```php
Schema::create('article', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title', 100);
    $table->ced(); //add 'created_by', 'updated_by' and 'deleted_by'
    $table->timestamps();
});
```

or you can add one of the 3 columns.

```php
Schema::create('article', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title', 100);
    $table->creator(); // Add created_by
    $table->editor(); // Add updated_by
    $table->destroyer(); // Add deleted_by
    $table->timestamps();
});
```

or with custom column name

```php
Schema::create('article', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title', 100);
    $table->creator('seng_gawe'); // Add seng_gawe
    $table->editor('seng_edit'); // Add seng_edit
    $table->destroyer('seng_ndelet'); // Add seng_ndelet
    $table->timestamps();
});
```

Then use `LaraCedTrait` on your model.

``` php
namespace App;

use LaraCed\LaraCedTrait;

class Article extends Model
{
    use LaraCedTrait;
}
```

The following methods become available on your models to help retrieve the users creating, updating and deleting (if using SoftDeletes).

```php
$model -> creator; // the user who created the model
$model -> editor; // the user who last updated the model
$model -> destroyer; // the user who deleted the model
```

If you want to define the `created_by`, `updated_by`, or `deleted_by` column names, add the following class constants to your model(s).
```php
const CREATED_BY = 'created_by';
const UPDATED_BY = 'updated_by';
const DELETED_BY = 'deleted_by';
```

## Dropping columns

You can drop auditable columns using `dropCed()` method.

```php
Schema::table('articles', function (Blueprint $table) {
    $table->dropCed();
});
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/RioRizkyRainey/lara-ced.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/RioRizkyRainey/LaraCed.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/RioRizkyRainey/LaraCed.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/RioRizkyRainey/lara-ced.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/RioRizkyRainey/lara-ced
[link-travis]: https://travis-ci.org/RioRizkyRainey/LaraCed
[link-code-quality]: https://scrutinizer-ci.com/g/RioRizkyRainey/LaraCed/
[link-downloads]: https://packagist.org/packages/RioRizkyRainey/lara-ced
[link-author]: https://github.com/RioRizkyRainey
