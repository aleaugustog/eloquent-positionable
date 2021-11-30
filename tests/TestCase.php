<?php

namespace Tests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Collection;
use Thytanium\EloquentPositionable\Dummy\Model;
use Thytanium\EloquentPositionable\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates a Laravel application instance.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        $app->register(new ServiceProvider($app));

        return $app;
    }

    /**
     * Create model instances.
     *
     * @param int|null $qty
     *
     * @return \Thytanium\EloquentPositionable\Dummy\Model|\Illuminate\Support\Collection
     */
    public static function createModel(?int $qty = 1): mixed
    {
        if ($qty === 1) {
            return Model::create();
        }

        return collect(array_fill(0, $qty, null))
            ->map(fn () => Model::create());
    }
}
