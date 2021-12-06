<?php

namespace Tests\Queries;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Thytanium\EloquentPositionable\Dummy\Model;

class OrderedTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * It sorts models by position in ascending order.
     *
     * @return void
     */
    public function test_sorts_by_position_in_asc_order(): void
    {
        static::createModel(3, [2, 0, 1]);

        Model::ordered('asc')
            ->get()
            ->each(function ($model, $index) {
                $this->assertEquals(
                    $index,
                    $model->getPosition(),
                );
            });
    }
}
