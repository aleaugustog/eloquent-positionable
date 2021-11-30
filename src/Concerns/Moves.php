<?php

namespace Thytanium\EloquentPositionable\Concerns;

use Illuminate\Support\Facades\DB;

trait Moves
{
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

        static::clearCurrentPosition();

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

    protected function moveIntermediatePositions(int $target, int $current, bool $goingUp): void
    {
        $this->setTemporaryPosition();

        $operator = $goingUp ? '+' : '-';

        static::positionBetween(
                $this->getPositionThresholds($target, $current, $goingUp),
            )
            ->update([
                $this->getPositionColumn() => DB::raw(
                    "{$this->getPositionColumn()} {$operator} 1",
                ),
            ]);
    }
}
