<?php

namespace Tests\SetsNewOrder;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Thytanium\EloquentPositionable\Dummy\Model;

class SetNewOrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * It sets a new order starting from position 1.
     *
     * @return void
     */
    public function test_sets_a_new_order_starting_from_one(): void
    {
        static::createModel(3, [3, 1, 2]);

        Model::setNewOrder([1, 2, 3]);

        $this->assertEquals(
            [1, 2, 3],
            Model::ordered()->pluck('id')->all(),
        );
    }

    /**
     * It sets a new order starting from position 0.
     *
     * @return void
     */
    public function test_sets_a_new_order_starting_from_zero(): void
    {
        static::createModel(3, [2, 0, 1]);

        Model::setNewOrder([1, 2, 3], 0);

        $this->assertEquals(
            [0, 1, 2],
            Model::ordered()->pluck('index')->all(),
        );
    }
}
