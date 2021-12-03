<?php

namespace Thytanium\EloquentPositionable\Concerns;

use Illuminate\Support\Facades\DB;

trait Moves
{
    /**
     * Moves the model a specific number of positions.
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
            if (static::isPositionTaken($target)) {
                $this->moveIntermediatePositions($target, $current, $goingUp);
            }

            $this->setFinalPosition($target);
        });

        return $this;
    }

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

    protected function setTemporaryPosition(): void
    {
        $this->setPosition(static::maxPosition() + 1);
        $this->save();
    }

    protected function setFinalPosition(int $position): self
    {
        $this->setPosition($position);
        $this->save();

        return $this;
    }

    protected function getPositionThresholds(int $target, int $current, bool $goingUp): array
    {
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
        $operator = $goingUp ? '+' : '-';

        return $this->updateBetweenPositions(
            $this->getPositionThresholds($target, $current, $goingUp),
            $operator,
        );
    }

    /**
     * Run update query for models between specific positions.
     *
     * @param array $between
     * @param string $operator
     *
     * @return int
     */
    protected function updateBetweenPositions(
        array $between,
        string $operator
    ): int {
        $this->setTemporaryPosition();

        $column = static::query()
            ->getGrammar()
            ->wrap($this->getPositionColumn());

        return static::positionBetween($between)
            ->update([
                $this->getPositionColumn() => DB::raw(
                    "{$column} {$operator} 1",
                ),
            ]);
    }
}
