<?php

namespace Tests\Moves;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Thytanium\EloquentPositionable\Dummy\Model;

class MoveStepTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * It moves a model up.
     *
     * @return void
     */
    public function test_it_moves_up(): void
    {
        $models = static::createModel(3);

        $this->assertEquals(
            [0, 1, 2],
            $this->mapPosition($models)->toArray(),
        );

        // move last item 2 places up
        $models[2]->moveStep(-2);

        $this->assertEquals(
            [1, 2, 0],
            $this->mapPosition($models, true)->toArray(),
        );
    }

    /**
     * It moves a model down.
     *
     * @return void
     */
    public function test_it_moves_down(): void
    {
        $models = static::createModel(3);

        $this->assertEquals(
            [0, 1, 2],
            $this->mapPosition($models)->toArray(),
        );

        // move last item 2 places up
        $models[2]->moveStep(-2);

        $this->assertEquals(
            [1, 2, 0],
            $this->mapPosition($models, true)->toArray(),
        );
    }

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
