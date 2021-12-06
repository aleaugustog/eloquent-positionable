<?php

namespace Thytanium\EloquentPositionable\Concerns;

use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

trait Moves
{
    /**
     * Moves the model to a desired position.
     *
     * @param int $target
     *
     * @return $this
     */
    public function moveTo(int $target): self
    {
        return $this->moveStep(
            $target - $this->getPosition(),
        );
    }

    /**
     * Move the model to the start.
     *
     * @return $this
     */
    public function moveToStart(): self
    {
        return $this->moveTo(
            $this->getPositionStart(),
        );
    }

    /**
     * Move the model to the end.
     *
     * @return $this
     */
    public function moveToEnd(): self
    {
        return $this->moveTo(
            $this->maxPosition(),
        );
    }

    /**
     * Move the model N places up.
     * By default it moves one place up.
     *
     * @param int|null $places
     *
     * @return $this
     */
    public function moveUp(?int $places = 1): self
    {
        return $this->moveStep(-1 * $places);
    }

    /**
     * Move the model N places down.
     * By default it moves one place down.
     *
     * @param int|null $places
     *
     * @return $this
     */
    public function moveDown(?int $places = 1): self
    {
        return $this->moveStep($places);
    }

    /**
     * Moves the model a desired number of positions.
     *
     * @param int $step
     *
     * @return $this
     */
    public function moveStep(int $step): self
    {
        // calculate target position
        [$target, $current, $goingUp] = $this->getTargetPosition($step);

        DB::transaction(function () use ($current, $goingUp, $target) {
            // move intermediate models from their positions
            // when the target position is taken
            if ($this->isPositionTaken($target)) {
                $this->moveIntermediatePositions($target, $current, $goingUp);
            }

            $this->setPositionAndSave($target);
        });

        return $this;
    }

    /**
     * Obtain target position based on step.
     *
     * @param int $step How many positions to move
     *
     * @return array
     */
    protected function getTargetPosition(int $step): array
    {
        // get current position
        $current = $this->getPosition();

        // calculate target
        $target = $current + $step;

        // do not allow to go higher than the top
        if ($step < 0 && $target < $this->positionStart) {
            $target = $this->positionStart;
        }

        return [$target, $current, $step < 0];
    }

    /**
     * Get lower and upper thresholds based on the target position,
     * current position and direction (up or down).
     *
     * @param int  $target
     * @param int  $current
     * @param bool $goingUp
     *
     * @return array
     */
    protected function getPositionThresholds(
        int $target,
        int $current,
        bool $goingUp
    ): array {
        $lower = $goingUp ? $target : $current + 1;
        $upper = $goingUp ? $current - 1 : $target;

        return [$lower, $upper];
    }

    /**
     * Move intermediate positions to make space for new positions.
     *
     * @param int $target
     * @param int $current
     * @param bool $goingUp
     *
     * @return int
     */
    protected function moveIntermediatePositions(
        int $target,
        int $current,
        bool $goingUp
    ): int {
        $operation = $goingUp ? 'increment' : 'decrement';

        return $this->updateBetweenPositions(
            $this->getPositionThresholds($target, $current, $goingUp),
            $operation,
        );
    }

    /**
     * Run update query for models between specific positions.
     *
     * @param array $between
     * @param string $operation 'increment' | 'decrement'
     *
     * @return int
     */
    protected function updateBetweenPositions(
        array $between,
        string $operation
    ): int {
        $this->setTemporaryPosition();

        $incrementing = $operation === 'increment';

        return $this->getPositionQuery()
            ->withoutGlobalScope(SoftDeletingScope::class)
            ->positionBetween($between)
            ->{$operation}($this->getPositionColumn());
    }
}
