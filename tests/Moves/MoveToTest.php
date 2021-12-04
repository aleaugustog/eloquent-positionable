<?php

namespace Tests\Moves;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MoveToTest extends TestCase
{
    use DatabaseMigrations, MapsModels;

    /**
     * It moves a model to a higher position.
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

        // move last item to first position
        $models[2]->moveTo(0);

        $this->assertEquals(
            [1, 2, 0],
            $this->mapPosition($models, true)->toArray(),
        );
    }

    /**
     * It moves a model to a higher position.
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

        // move last item to last position
        $models[0]->moveTo(2);

        $this->assertEquals(
            [2, 0, 1],
            $this->mapPosition($models, true)->toArray(),
        );
    }
}
