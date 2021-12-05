# thytanium/eloquent-positionable

Use a property to sort Eloquent models.

This is a zero-config package that provides a trait to handle positioning/sorting capabilities for Eloquent models.

## Compatibility

**PHP >= 7.3** and **Laravel >= 6.0**.

## Installation

This package can be installed through composer.

> Don't worry about service providers, this package doesn't expose service providers.

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

## Groups

## Caveats

> Although this trait makes sure the same position is not used by more than one model, do not add a `UNIQUE` index to the position column. This will be overcome in future releases.
