# SPOT: Simple PHP Object Tracker

[![Latest Version on Packagist](https://img.shields.io/packagist/v/richtoms/spot.svg?style=flat-square)](https://packagist.org/packages/richtoms/spot)
[![Build Status](https://img.shields.io/travis/richtoms/spot/master.svg?style=flat-square)](https://travis-ci.org/richtoms/spot)
[![Quality Score](https://img.shields.io/scrutinizer/g/richtoms/spot.svg?style=flat-square)](https://scrutinizer-ci.com/g/richtoms/spot)
[![Total Downloads](https://img.shields.io/packagist/dt/richtoms/spot.svg?style=flat-square)](https://packagist.org/packages/richtoms/spot)

SPOT is a small library designed to track timing and memory usage of your PHP functions and class methods.

## Installation

You can install the package via composer:

```bash
composer require richtoms/spot
```

## Usage
Using the class tracker for a class.

``` php
use RichToms\Spot\ClassTracker;

$tracker = new ClassTracker(new Foo('Bar'));
$tracker->methodOnFoo()
    ->anotherMethod()
    ->andAnother();

// Result of fluently calling methods on the `Foo` class.
$result = $tracker->getResult();

// List of events tracked while calling many methods on the `Foo` class.
$events = $tracker->getEvents();
```

Using the closure tracker.
```php
$tracker = new ClosureTracker(function ($array) {
    return array_map(function ($item) {
        return $x += 1;
    }, $array);
}, [[1, 2, 3, 4]]);

// Result of the Closure.
$result = $tracker->getResult();

// List of events tracked when calling the Closure.
$result->getEvents();
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email richard.toms@hotmail.com instead of using the issue tracker.

## Credits

- [Richard Toms](https://github.com/richtoms)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.