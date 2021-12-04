<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait MapsModels
{
    /**
     * Map a model collection to positions only.
     *
     * @param \Illuminate\Support\Collection $models
     * @param bool|null                      $refresh
     *
     * @return \Illuminate\Support\Collection
     */
    protected function mapPosition(
        Collection $models,
        ?bool $refresh =  false
    ): Collection {
        return $models->map(function (Model $model) use ($refresh) {
            if ($refresh) {
                $model->refresh();
            }

            return $model->getPosition();
        });
    }
}
