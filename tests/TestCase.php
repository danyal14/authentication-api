<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use \Laravel\Lumen\Testing\DatabaseMigrations;

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
