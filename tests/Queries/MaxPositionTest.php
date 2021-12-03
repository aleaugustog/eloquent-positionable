<?php

namespace Tests\Queries;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Thytanium\EloquentPositionable\Dummy\Model;

class MaxPositionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * It finds the max position when there is at least one model.
     *
     * @return void
     */
    public function test_it_finds_max_position(): void
    {
        static::createModel();

        $this->assertEquals(
            0,
            Model::maxPosition(),
        );
    }

    /**
     * It does not find the max position when there are no models.
     *
     * @return void
     */
    public function test_it_does_not_find_max_position(): void
    {
        $this->assertEquals(
            -1,
            Model::maxPosition(),
        );
    }
}
