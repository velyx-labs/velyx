<x-docs.layout :title="$title" :nav-key="$navKey" :around="$around" section="Getting started"
    :toc="['what' => 'What Velyx is', 'how' => 'How it works', 'requirements' => 'Requirements']">
    <x-docs.page-header section="Getting started" :title="$title" description="Accessible Blade, Livewire and Alpine components you copy into your Laravel app with one command." />

    <x-docs.section id="what" title="What Velyx is">
        <div class="docs-prose">
            <p>
                Velyx is not a package you install and update. It is a set of Blade components, and a CLI that copies them into
                <code>resources/views/components/ui</code>. From then on the files are yours: they show up in code review, and you can
                change anything.
            </p>
            <p>
                Components are styled with Tailwind CSS v4 and a small set of theme tokens, so they match your app instead of a library's
                look. They work with Livewire and Alpine when you use them, and as plain Blade when you do not.
            </p>
        </div>
    </x-docs.section>

    <x-docs.section id="how" title="How it works">
        <ol class="flex flex-col gap-5">
            @foreach ([
                ['velyx init', 'Detects Laravel and Tailwind, writes velyx.json and your theme stylesheet, and installs the icon component.'],
                ['velyx add button', 'Copies the component and the components it needs. It never overwrites a file you changed without asking.'],
                ['git diff', 'Review the files like any other change, then commit them.'],
            ] as [$command, $text])
                <li class="flex gap-5">
                    <x-docs.step-number :number="$loop->iteration" />
                    <div class="flex min-w-0 flex-1 flex-col gap-2">
                        <code class="self-start rounded-md bg-terminal px-3 py-1.5 font-mono text-code text-on-terminal">{{ $command }}</code>
                        <p class="docs-prose">{{ $text }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </x-docs.section>

    <x-docs.section id="requirements" title="Requirements">
        <ul class="docs-prose">
            <li>Laravel 11 or later, PHP 8.2 or later.</li>
            <li>Tailwind CSS v4.</li>
            <li>Livewire 3 or later and Alpine.js, only for the components that use them.</li>
        </ul>
        <p class="docs-prose">Ready? Head to <a href="{{ route('docs.guide', 'installation') }}">Installation</a>.</p>
    </x-docs.section>
</x-docs.layout>
