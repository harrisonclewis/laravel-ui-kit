<?php

namespace LaravelUiKit\Tests;

use LaravelUiKit\LaravelUiKitServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function defineEnvironment($app)
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
    }

    protected function getPackageProviders($app)
    {
        return [LaravelUiKitServiceProvider::class, LivewireServiceProvider::class];
    }
}
