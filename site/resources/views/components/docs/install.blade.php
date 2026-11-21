@props([
    'manifest',
])

@php
    $dependencies = $manifest['dependencies']['components'] ?? [];
    $usesIcons = in_array('icon', $dependencies, true);
    $folder = 'resources/views/components/ui';
@endphp

<div x-data="{ tab: 'command' }" class="flex flex-col gap-[18px]">
    <div role="tablist" aria-label="Installation method" class="flex gap-6 border-b border-border">
        @foreach (['command' => 'Command', 'manual' => 'Manual'] as $key => $label)
            <button
                type="button"
                role="tab"
                x-on:click="tab = @js($key)"
                x-bind:aria-selected="tab === @js($key)"
                x-bind:class="tab === @js($key) ? 'border-ink text-ink' : 'border-transparent text-ink-subtle hover:text-ink'"
                class="-mb-px h-[38px] border-b-2 text-control font-medium transition-colors"
            >{{ $label }}</button>
        @endforeach
    </div>

    <div x-show="tab === 'command'" role="tabpanel">
        <x-docs.command :command="'velyx add '.$manifest['name']" />
    </div>

    {{-- Only read in the Markdown copy of the page, where both tabs show. --}}
    <p class="hidden">Or install it by hand:</p>

    <ol x-show="tab === 'manual'" x-cloak role="tabpanel" class="flex flex-col gap-7">
        @php($step = 0)

        @if ($usesIcons)
            <li class="flex gap-5">
                <x-docs.step-number :number="++$step" />
                <div class="flex min-w-0 flex-1 flex-col gap-3 docs-prose">
                    <p>Install the icon package for your set (Lucide by default), and the <a href="{{ route('docs.guide', 'icons') }}">icon component</a> if you do not have it yet.</p>
                    <x-docs.code code="composer require mallardduck/blade-lucide-icons" file="Terminal" icon="terminal-2" :numbers="false" />
                </div>
            </li>
        @endif

        @foreach (array_diff($dependencies, ['icon']) as $dependency)
            <li class="flex gap-5">
                <x-docs.step-number :number="++$step" />
                <p class="docs-prose pt-0.5">Install <a href="{{ route('docs.component', $dependency) }}"><code>{{ $dependency }}</code></a> first.</p>
            </li>
        @endforeach

        <li class="flex gap-5">
            <x-docs.step-number :number="++$step" />
            <div class="flex min-w-0 flex-1 flex-col gap-3">
                <p class="docs-prose">Copy {{ count($manifest['files']) === 1 ? 'this file' : 'these files' }} into <code>{{ $folder }}</code>.</p>
                @foreach ($manifest['files'] as $file)
                    <x-docs.code :code="$file['content']" :file="$folder.'/'.$file['target']" expandable />
                @endforeach
            </div>
        </li>
    </ol>
</div>
