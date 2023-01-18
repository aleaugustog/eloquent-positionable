# thytanium/eloquent-positionable

![Tests](https://github.com/thytanium/eloquent-positionable/actions/workflows/test.yml/badge.svg)
[![Latest Stable Version](http://poser.pugx.org/thytanium/eloquent-positionable/v)](https://packagist.org/packages/thytanium/eloquent-positionable)
[![Total Downloads](http://poser.pugx.org/thytanium/eloquent-positionable/downloads)](https://packagist.org/packages/thytanium/eloquent-positionable)
[![PHP Version Require](http://poser.pugx.org/thytanium/eloquent-positionable/require/php)](https://packagist.org/packages/thytanium/eloquent-positionable)
[![License](http://poser.pugx.org/thytanium/eloquent-positionable/license)](https://packagist.org/packages/thytanium/eloquent-positionable)

Use a property to sort Eloquent models.

This is a zero-config package that provides a trait to handle positioning/sorting capabilities for Eloquent models.

## Compatibility

**PHP >= 7.3** and **Laravel >= 6.0**.

## Installation

This package can be installed through composer.

> Don't worry about service providers. This package doesn't expose service providers.

```bash
composer require thytanium/eloquent-positionable
```

## Usage

-   Add the trait `Thytanium\EloquentPositionable\Positionable` to your model.
-   Optionally, specify the column name.
    -   If no column name is provided, the column `position` will be used for positioning models.

```php
use Illuminate\Database\Eloquent\Model;
use Thytanium\EloquentPositionable\Positionable;

class MyModel extends Model
{
    use Positionable;

    // optional parameters
    protected $positionable = [
        'column' => 'column_name', // column used for positioning
        'start' => 5, // starting position
    ];
}
```

Creating a new model will automatically assign the next available position.

```php
$myModel = new MyModel();
$myModel->save();

$myModel->getPosition(); // by default will return 1, or the custom starting position
```

## API

### Sorting

#### `moveTo(int $position)`

Moves the model to the indicated position.

```php
$model->moveTo(5); // moves model to position 5
```

#### `moveToStart()`

Moves the model to the start.

```php
$model->moveToStart();
```

#### `moveToEnd()`

Moves the model to the end.

```php
$model->moveToEnd();
```

#### `moveUp(?int $places = 1)`

Moves the model the indicated amount of places up. Default `1`.

```php
$model->moveUp(); // moves the model 1 place up
$model->moveUp(5); // moves the model 5 places up
```

#### `moveDown(?int $places = 1)`

Moves the model the indicated amount of places down. Default `1`.

```php
$model->moveDown(); // moves the model 1 place down
$model->moveDown(5); // moves the model 5 places down
```

#### `moveStep(int $step)`

Moves the model by position change (step).
A positive values moves the model up.
A negative value moves the model down.

```php
$model->moveStep(-1); // moves the model 1 place up
$model->moveStep(1); // moves the model 1 place down
```

#### Set new order

Sets a new order for the specified ids.

```php
Model::setNewOrder([1, 2, 3]); // sets sequencial order on models with ids 1, 2 and 3 starting from position 1
Model::setNewOrder([1, 2, 3], 5); // sets sequencial order on models with ids 1, 2 and 3 starting from position 5
```

### Querying

#### `ordered($order = 'asc'): \Illuminate\Database\Eloquent\Builder`

Query scope to sort models by their position, i.e get the sorted list.

```php
MyModel::ordered()->get(); // get all models in ascending order
MyModel::ordered('desc')->get(); // get all models in descending order
```

#### `position(int $position): \Illuminate\Database\Eloquent\Builder`

Query scope to search models with position equal to `$position`.

```php
MyModel::position(1)->first(); // get the model at the start
```

#### `positionBetween(array $between): \Illuminate\Database\Eloquent\Builder`

Query scope to search models with position between 2 values.

```php
MyModel::positionBetween([1, 9])->get(); // get models between positions 1 and 9
MyModel::positionBetween([1, 9])->ordered()->get(); // get models in ordered fashion between positions 1 and 9
```

### Swaping

#### `swapPositions(\Illuminate\Database\Eloquent\Model|int $target)`

Swap positions with another model or position.

```php
$model1->swapPositions($model2); // swap position with another model instance
$model1->swapPositions(2); // swap position with whichever model holds position 2
```

## Groups

In the case your model has grouping fields, like `user_id`, it can be taken care of by indicating the grouping column names:

```php
use Illuminate\Database\Eloquent\Model;
use Thytanium\EloquentPositionable\Positionable;

class MyModel extends Model
{
    use Positionable;

    // optional parameters
    protected $positionable = [
        'column' => 'column_name', // column used for positioning
        'start' => 5, // starting position
        'groups' = ['user_id'], // columns for grouping
    ];
}
```

##### Example

| id  | user_id | position |
| --- | ------- | -------- |
| 1   | 1       | 1        |
| 2   | 1       | 2        |
| 3   | 1       | 3        |
| 4   | 2       | 1        |

## Caveats

Although this trait makes sure the same position is not used by more than one model, do not add a `UNIQUE` index to the position column. This will be overcome in future releases.

## Tests

The package contains unit/integration tests set up with PHPUnit.

```bash
composer test
```

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## Alternatives

-   [spatie/eloquent-sortable](https://github.com/spatie/eloquent-sortable)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
