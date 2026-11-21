<?php

namespace Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Codeat3\BladePhosphorIcons\BladePhosphorIconsServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use MallardDuck\LucideIcons\BladeLucideIconsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use secondnetwork\TablerIcons\BladeTablerIconsServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Stages every registry component at its install target, as `velyx add` would.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $views = sys_get_temp_dir().'/velyx-registry-views';
        File::deleteDirectory($views);

        foreach (File::directories(__DIR__.'/../../components') as $dir) {
            $manifest = json_decode(File::get($dir.'/component.json'), true);

            foreach ($manifest['files'] as $file) {
                $target = $views.'/components/ui/'.$file['target'];
                File::ensureDirectoryExists(dirname($target));
                File::copy($dir.'/'.$file['path'], $target);
            }
        }

        View::addLocation($views);
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeLucideIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeTablerIconsServiceProvider::class,
            BladePhosphorIconsServiceProvider::class,
        ];
    }
}
