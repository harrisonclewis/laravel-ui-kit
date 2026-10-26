<?php

namespace LaravelUiKit\Tests;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use LaravelUiKit\LaravelUiKitServiceProvider;
use LaravelUiKit\Tests\Fixtures\ProfileForm;
use Livewire\Livewire;

class CompatibilityTest extends TestCase
{
    public function test_every_registered_component_renders(): void
    {
        foreach (config('ui-kit.components') as $alias => $options) {
            if ($alias === 'sidebar-icon') {
                $template = '<x-sidebar-icon component="spinner" />';
            } elseif ($alias === 'accordion-item') {
                $template = '<x-accordion-item id="first" title="Details">Content</x-accordion-item>';
            } elseif ($alias === 'dropdown') {
                $template = '<x-dropdown><x-slot:trigger>Menu</x-slot:trigger> Content</x-dropdown>';
            } else {
                $template = "<x-{$alias}>Content</x-{$alias}>";
            }

            $this->assertNotEmpty(Blade::render($template), $alias);
        }
    }

    public function test_livewire_attributes_and_state_survive_rendering_and_updates(): void
    {
        Livewire::test(ProfileForm::class)
            ->assertSeeHtml('wire:model.live="name"')
            ->assertSeeHtml('wire:click="save"')
            ->set('name', 'Updated name')
            ->call('save')
            ->assertSet('saved', 'Updated name')
            ->assertSee('Updated name');
    }

    public function test_form_method_spoofing_and_csrf_are_preserved(): void
    {
        $html = Blade::render('<x-form method="PATCH" action="/profile"><x-input name="name" /></x-form>');

        $this->assertStringContainsString('method="POST"', $html);
        $this->assertStringContainsString('name="_method" value="PATCH"', $html);
        $this->assertStringContainsString('name="_token"', $html);
    }

    public function test_classes_can_include_missing_config_values_and_nested_arrays(): void
    {
        $this->assertSame('block dark:text-white', Str::mergeClasses(null, '', ['block', ['dark:text-white', null]], ' block '));
        $this->assertSame('', Str::mergeClasses(null));
        $this->assertSame('hover:block hover:text-white', Str::prefixClasses('hover:', '  block   text-white  '));
    }

    public function test_published_config_contains_all_required_files_and_can_be_loaded(): void
    {
        $this->artisan('vendor:publish', [
            '--provider' => LaravelUiKitServiceProvider::class,
            '--tag' => 'config',
            '--force' => true,
        ])->assertExitCode(0);

        try {
            $published = require config_path('ui-kit.php');
            $defaults = require __DIR__.'/../config/ui-kit.php';
            $this->assertSame($defaults, $published);

            foreach (glob(__DIR__.'/../config/ui-kit/*.php') as $file) {
                $this->assertFileExists(config_path('ui-kit/'.basename($file)));
            }
        } finally {
            $this->app['files']->delete(config_path('ui-kit.php'));
            $this->app['files']->deleteDirectory(config_path('ui-kit'));
        }
    }
}
