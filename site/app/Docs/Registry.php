<?php

namespace App\Docs;

use Illuminate\Support\Facades\File;
use RuntimeException;

/**
 * Reads the static registry the CLI installs from, so component pages show
 * the real version, dependencies and source files.
 */
class Registry
{
    public function __construct(private string $path) {}

    /**
     * @return array{name: string, version: string, description: string, dependencies?: array{components?: list<string>, composer?: list<string>, npm?: list<string>}, files: list<array{path: string, target: string, content: string}>}
     */
    public function component(string $name): array
    {
        $file = $this->path.'/components/'.$name.'.json';

        if (! File::exists($file)) {
            throw new RuntimeException("Component [{$name}] is not in the registry at {$this->path}.");
        }

        return json_decode(File::get($file), true, flags: JSON_THROW_ON_ERROR);
    }

    /**
     * @return list<string>
     */
    public function dependencies(string $name): array
    {
        return $this->component($name)['dependencies']['components'] ?? [];
    }

    /**
     * The icon libraries the CLI offers, keyed by set name.
     *
     * @return array<string, array{label: string, package: string|null}>
     */
    public function iconSets(): array
    {
        $icons = json_decode(File::get($this->path.'/icons.json'), true, flags: JSON_THROW_ON_ERROR);

        return collect($icons['libraries'])
            ->map(fn (array $set): array => ['label' => $set['label'], 'package' => $set['composer']])
            ->all();
    }

    /**
     * Every Velyx icon name, with the icon it maps to in each set.
     *
     * @return array<string, array<string, string>>
     */
    public function icons(): array
    {
        return json_decode(File::get($this->path.'/icons.json'), true, flags: JSON_THROW_ON_ERROR)['icons'];
    }

    /**
     * The theme choices offered at init.
     *
     * @return array{defaults: array<string, string>, bases: array<string, array{swatch: string}>, accents: array<string, string>, radii: list<string>}
     */
    public function themes(): array
    {
        return json_decode(File::get($this->path.'/themes.json'), true, flags: JSON_THROW_ON_ERROR);
    }
}
