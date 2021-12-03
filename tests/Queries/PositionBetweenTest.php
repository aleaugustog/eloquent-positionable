<?php

namespace Tests\Queries;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Thytanium\EloquentPositionable\Dummy\Model;

class PositionBetweenTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * It queries models between 2 positions.
     *
     * @return void
     */
    public function test_it_queries_models_between_positions(): void
    {
        static::createModel(3);

        $result = Model::positionBetween([0, 1])->get();

        // it returns the correct amount of items
        $this->assertCount(
            2,
            $result->toArray(),
        );

        // it returns the correct positions
        $result->each(function ($model, $index) {
            $this->assertEquals(
                $index,
                $model->getPosition(),
            );
        });
    }
}
