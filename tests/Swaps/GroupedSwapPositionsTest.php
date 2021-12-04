<?php

namespace Tests\Swaps;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\MapsModels;
use Tests\TestCase;

class GroupedSwapPositionsTest extends TestCase
{
    use DatabaseMigrations, MapsModels;

    /**
     * It swaps positions by passing a position number.
     *
     * @return void
     */
    public function test_it_swaps_positions_with_position_number(): void
    {
        $models = static::createGroupedModel(3, ['type A', 'type B', 'type A']);

        $this->assertEquals(
            [1, 1, 2],
            $this->mapPosition($models)->toArray(),
        );

        // swap positions between first and last model
        $models[2]->swapPositions(1);

        $this->assertEquals(
            [2, 1, 1],
            $this->mapPosition($models, true)->toArray(),
        );
    }

    /**
     * It swaps positions by passing another model.
     *
     * @return void
     */
    public function test_it_swaps_positions_with_model(): void
    {
        $models = static::createGroupedModel(3, ['type A', 'type B', 'type A']);

        $this->assertEquals(
            [1, 1, 2],
            $this->mapPosition($models)->toArray(),
        );

        // swap positions between first and last model
        $models[2]->swapPositions($models[0]);

        $this->assertEquals(
            [2, 1, 1],
            $this->mapPosition($models, true)->toArray(),
        );
    }
}
