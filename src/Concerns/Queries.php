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
        string $order = 'asc'
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
     * Get max position.
     * If max position is null then `positionStart - 1` will be returned.
     *
     * @return int
     */
    public function maxPosition(): int
    {
        return $this->getPositionQuery()->max($this->getPositionColumn())
                ?? $this->getPositionStart() - 1;
    }

    /**
     * Returns true when a given position is taken.
     *
     * @param int $position
     *
     * @return bool
     */
    protected function isPositionTaken(int $position): bool
    {
        return $this->getPositionQuery()
            ->where((new static)->getPositionColumn(), $position)
            ->count() !== 0;
    }

    /**
     * Base query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getPositionQuery(): Builder
    {
        return self::query()->when(
            count($this->getPositionGroups()) > 0,
            function ($query) {
                foreach ($this->getPositionGroups() as $column) {
                    $query->where(
                        $column,
                        $this->getAttribute($column),
                    );
                }
            },
        );
    }
}
