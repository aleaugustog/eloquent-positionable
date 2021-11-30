<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Thytanium\EloquentPositionable\Dummy\Model;

class PositionableTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test it assigns positions when not provided.
     *
     * @return void
     */
    public function test_it_assigns_initial_positions(): void
    {
        static::createModel(2)
            ->each(function ($model, $index) {
                $this->assertEquals(
                    $index,
                    $model->getPosition(),
                );
            });
    }

    /**
     * Test it does not overwrite the provided position.
     *
     * @return void
     */
    public function test_it_respects_provided_position(): void
    {
        // create model with position = 2
        $model = new Model();
        $model->setPosition(2);
        $model->save();

        // refresh value from db
        $model->refresh();

        $this->assertEquals(
            2,
            $model->getPosition(),
        );
    }
}
