<?php

namespace Thytanium\EloquentPositionable;

use Illuminate\Database\Eloquent\Model;

trait Positionable
{
    use Concerns\Moves, Concerns\Queries, Concerns\Swaps;

    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootPositionable(): void
    {
        static::saving(function (Model $model) {
            if ($model->getPosition() === null) {
                $model->setPosition($model->maxPosition() + 1);
            }
        });
    }

    /**
     * Get the name of the column used for positioning.
     * Default = 'position'.
     *
     * @return string
     */
    public function getPositionColumn(): string
    {
        return $this->positionable['column'] ?? 'position';
    }

    /**
     * Get the start number for positioning models.
     * Default = 1.
     *
     * @return int
     */
    public function getPositionStart(): int
    {
        return $this->positionable['start'] ?? 1;
    }

    /**
     * Get position group columns.
     *
     * @return array
     */
    public function getPositionGroups(): array
    {
        return $this->positionable['groups'] ?? [];
    }

    /**
     * Sets a temporary position equal to the max position + 1.
     *
     * @return void
     */
    protected function setTemporaryPosition(): void
    {
        $this->setPosition($this->maxPosition() + 1);
        $this->save();
    }

    /**
     * Sets a position value and saves the model.
     *
     * @param int $position Desired position
     *
     * @return $this
     */
    protected function setPositionAndSave(int $position): self
    {
        $this->setPosition($position);
        $this->save();

        return $this;
    }
}
