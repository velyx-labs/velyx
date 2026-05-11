<?php

declare(strict_types=1);

namespace App\Livewire\Docs;

use Livewire\Component;

class Sidebar extends Component
{
    /**
     * @return array<string, array{url: string, children?: array<string, string>}>
     */
    public function getNavigationProperty(): array
    {
        return config('velyx-docs.navigation', []);
    }
}
