<?php

namespace Tests;

use Thytanium\EloquentPositionable\Dummy\Model;

trait CreatesModels
{
    /**
     * Create model instances.
     *
     * @param int|null   $qty
     * @param array|null $positions
     *
     * @return \Thytanium\EloquentPositionable\Dummy\Model|\Illuminate\Support\Collection
     */
    public static function createModel(
        ?int $qty = 1,
        ?array $positions = []
    ): mixed {
        if ($qty === 1) {
            return Model::create();
        }

        return collect(array_fill(0, $qty, null))
            ->map(fn ($nil, $index) => Model::create(
                count($positions)
                    ? [(new Model)->getPositionColumn() => $positions[$index]]
                    : [],
            ));
    }
}
