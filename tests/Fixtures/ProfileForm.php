<?php

namespace LaravelUiKit\Tests\Fixtures;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;

class ProfileForm extends Component
{
    public string $name = '';

    public string $saved = '';

    public function save(): void
    {
        $this->saved = $this->name;
    }

    public function render()
    {
        return Blade::render(<<<'BLADE'
            <div>
                <x-input wire:model.live="name" />
                <x-button wire:click="save">Save</x-button>
                <x-text>{{ $saved }}</x-text>
            </div>
            BLADE, ['saved' => $this->saved]);
    }
}
