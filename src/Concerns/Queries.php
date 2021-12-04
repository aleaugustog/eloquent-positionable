<?php

namespace Thytanium\EloquentPositionable\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Queries
{
    /**
     * Query models with specific position.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int                                   $position
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePosition(Builder $query, int $position): Builder
    {
        return $query->where(
            $this->getPositionColumn(),
            $position,
        );
    }

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

    /**
     * Sorts query by position.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null                           $order
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered(
        Builder $query,
        ?string $order = 'asc'
    ): Builder {
        return $query->orderBy(
            $this->getPositionColumn(),
            $order,
        );
    }

    /**
     * Get current position.
     *
     * @return int
     */
    public function getPosition(): ?int
    {
        return $this->getAttribute($this->getPositionColumn());
    }

    /**
     * Set current position.
     *
     * @return $this
     */
    public function setPosition(int $position): static
    {
        $this->{$this->getPositionColumn()} = $position;

        return $this;
    }

    /**
     * Returns true when a given position is taken.
     *
     * @param int $position
     *
     * @return bool
     */
    public static function isPositionTaken(int $position): bool
    {
        return static::getPositionQuery()
            ->where((new static)->getPositionColumn(), $position)
            ->count() !== 0;
    }

    /**
     * Get max position.
     * If max position is null then `positionStart - 1` will be returned.
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

    /**
     * Base query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function getPositionQuery(): Builder
    {
        return static::query();
    }
}
