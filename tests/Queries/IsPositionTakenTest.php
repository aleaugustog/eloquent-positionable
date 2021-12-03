<?php

namespace Tests\Queries;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Thytanium\EloquentPositionable\Dummy\Model;

class IsPositionTakenTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * It returns true whena a given position is taken.
     *
     * @return void
     */
    public function test_it_returns_true_when_position_is_taken(): void
    {
        $model = static::createModel();

        $this->assertTrue(
            Model::isPositionTaken(
                $model->getPosition(),
            ),
        );
    }

    /**
     * It returns false when a given position is not taken.
     *
     * @return void
     */
    public function test_it_returns_false_when_position_is_not_taken(): void
    {
        $model = static::createModel();

        $this->assertFalse(
            Model::isPositionTaken(
                $model->getPosition() + 1,
            ),
        );
    }
}
