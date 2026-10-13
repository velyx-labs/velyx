<?php

declare(strict_types=1);

namespace App\Livewire\Docs;

use App\Support\DocsNavigation;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Sidebar extends Component
{
    /**
     * @return list<array{name: string, path: string, items: list<array<string, mixed>>, groups: list<array<string, mixed>>}>
     */
    #[Computed]
    public function sections(): array
    {
        return app(DocsNavigation::class)->sections();
    }

    #[Computed]
    public function cliVersion(): ?string
    {
        return Cache::remember('velyx_cli_version', 3600, function (): ?string {
            $manifest = base_path('tools/cli/package.json');

            if (! is_file($manifest)) {
                return null;
            }

            return json_decode((string) file_get_contents($manifest), true)['version'] ?? null;
        });
    }
}
