<?php

namespace Tests;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Thytanium\EloquentPositionable\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesModels;

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
}
