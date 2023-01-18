<?php

namespace Thytanium\EloquentPositionable\Concerns;

use Illuminate\Database\Eloquent\SoftDeletingScope;

trait SetsNewOrder
{
    /**
     * Sets a new order for the specified ids.
     *
     * @param int[] $ids
     * @param int $startPosition
     * @param string $primaryKeyColumn
     *
     * @return void
     */
    public static function setNewOrder(
        array $ids,
        int $startPosition = 1,
        ?string $primaryKeyColumn = null
    ): void {
        $model = new static();

        $positionColumnName = $model->getPositionColumn();

        if (is_null($primaryKeyColumn)) {
            $primaryKeyColumn = $model->getKeyName();
        }

        foreach ($ids as $id) {
            static::withoutGlobalScope(SoftDeletingScope::class)
                ->where($primaryKeyColumn, $id)
                ->update([$positionColumnName => $startPosition++]);
        }
    }
}
