<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Registry
    |--------------------------------------------------------------------------
    |
    | The static registry built by `make registry`. Component pages read their
    | version, dependencies and source files from it, so the docs always show
    | what the CLI installs.
    |
    */

    'registry' => env('DOCS_REGISTRY_PATH', base_path('../registry/build')),

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    |
    | Guides live in resources/views/docs/guides/{slug}.blade.php and component
    | pages in resources/views/docs/components/{slug}.blade.php. The order here
    | drives the sidebar and the previous / next links.
    |
    */

    'guides' => [
        'introduction' => 'Introduction',
        'installation' => 'Installation',
        'cli' => 'CLI',
        'icons' => 'Icons',
        'theming' => 'Theming',
    ],

    'components' => [
        'button' => 'Button',
        'input' => 'Input',
        'label' => 'Label',
        'card' => 'Card',
        'badge' => 'Badge',
    ],

    /*
    | Pages to flag as new in the sidebar, as navigation keys such as
    | "component:button" or "guide:theming". Clear an entry once it has
    | been out for a while.
    */

    'new' => [],

    'repository' => 'https://github.com/velyx-labs/velyx',

];
