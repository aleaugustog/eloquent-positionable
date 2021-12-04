<?php

namespace Thytanium\EloquentPositionable\Concerns;

use Illuminate\Support\Facades\DB;

trait Swaps
{
    /**
     * Swaps positions by indicating another model or another position.
     *
     * @param int|\Illuminate\Database\Eloquent\Model $target
     *
     * @return $this
     */
    public function swapPositions(mixed $target): static
    {
        if (is_int($target)) {
            // find the model occupying the target position
            $target = self::position($target)->first();
        }

        DB::transaction(function () use ($target) {
            $current = $this->getPosition();
            $new = $target->getPosition();

            if ($target !== null) {
                $this->setTemporaryPosition();

                $target->moveTo($current);
            }

            $this->moveTo($new);
        });

        return $this;
    }
}
