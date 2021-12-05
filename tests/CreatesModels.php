<?php

namespace Tests;

use Thytanium\EloquentPositionable\Dummy\GroupedModel;
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
        int $qty = 1,
        array $positions = []
    ): object {
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

    /**
     * Create GroupedModel instances.
     *
     * @param int|null     $qty
     * @param array|null   $type
     * @param array|null   $positions
     *
     * @return \Thytanium\EloquentPositionable\Dummy\GroupedModel|\Illuminate\Support\Collection
     */
    public static function createGroupedModel(
        int $qty = 1,
        array $type = ['type A'],
        array $positions = []
    ): object {
        if ($qty === 1) {
            return GroupedModel::create(['type' => $type[0]]);
        }

        return collect(array_fill(0, $qty, null))->map(
            fn($nil, $index) => GroupedModel::create([
                'type' => $type[$index],
                ...count($positions) ? [
                    (new GroupedModel())->getPositionColumn() => $positions[
                        $index
                    ],
                ] : [],
            ])
        );
    }
}
