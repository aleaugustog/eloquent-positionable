<?php

namespace Thytanium\EloquentPositionable\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Queries
{
    /**
     * Query models with positions between two values.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $between
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePositionBetween(
        Builder $query,
        array $between
    ): Builder {
        return $query->whereBetween(
            $this->getPositionColumn(),
            $between,
        );
    }

    public function getPosition(): ?int
    {
        return $this->getAttribute($this->getPositionColumn());
    }

    public function setPosition(int $position): self
    {
        $this->{$this->getPositionColumn()} = $position;

        return $this;
    }

    public static function isPositionTaken(int $position): bool
    {
        return static::getPositionQuery()
            ->where((new static)->getPositionColumn(), $position)
            ->count() !== 0;
    }

    /**
     * Get max position.
     * If max position is null then `positionStart` - 1 will be returned.
     *
     * @return int
     */
    public static function maxPosition(): int
    {
        $model = new static;
        return static::query()
            ->max($model->getPositionColumn())
                ?? $model->getPositionStart() - 1;
    }

    protected static function getPositionQuery(): Builder
    {
        return static::query();
    }
}
