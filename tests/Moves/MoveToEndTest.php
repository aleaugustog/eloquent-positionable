<?php

namespace Tests\Moves;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\MapsModels;
use Tests\TestCase;

class MoveToEndTest extends TestCase
{
    use DatabaseMigrations, MapsModels;

    /**
     * It moves a model to the end.
     *
     * @return void
     */
    public function test_it_moves_to_end(): void
    {
        $models = static::createModel(3);

        $this->assertEquals(
            [0, 1, 2],
            $this->mapPosition($models)->toArray(),
        );

        // move first item to end
        $models[0]->moveToEnd();

        $this->assertEquals(
            [2, 0, 1],
            $this->mapPosition($models, true)->toArray(),
        );
    }
}
