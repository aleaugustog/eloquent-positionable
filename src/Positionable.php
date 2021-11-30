<?php

namespace Thytanium\EloquentPositionable;

use Illuminate\Database\Eloquent\Model;
use Thytanium\EloquentPositionable\Concerns\Moves;
use Thytanium\EloquentPositionable\Concerns\Queries;

trait Positionable
{
    use Moves, Queries;

    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootPositionable(): void
    {
        static::saving(function (Model $model) {
            if ($model->getPosition() === null) {
                $model->setPosition(static::maxPosition() + 1);
            }
        });
    }

    /**
     * Get the name of the column used for positioning.
     * Default = 'position'.
     *
     * @return string
     */
    protected function getPositionColumn(): string
    {
        return $this->positionColumn ?? 'position';
    }

    /**
     * Get the start number for positioning models.
     * Default = 1.
     *
     * @return int
     */
    protected function getPositionStart(): int
    {
        return $this->positionStart ?? 1;
    }
}
