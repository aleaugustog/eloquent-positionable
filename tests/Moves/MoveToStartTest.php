<?php

namespace Tests\Moves;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\MapsModels;
use Tests\TestCase;

class MoveToStartTest extends TestCase
{
    use DatabaseMigrations, MapsModels;

    /**
     * It moves a model to the start.
     *
     * @return void
     */
    public function test_it_moves_to_start(): void
    {
        $models = static::createModel(3);

        $this->assertEquals(
            [0, 1, 2],
            $this->mapPosition($models)->toArray(),
        );

        // move last item to start
        $models[2]->moveToStart();

        $this->assertEquals(
            [1, 2, 0],
            $this->mapPosition($models, true)->toArray(),
        );
    }
}
