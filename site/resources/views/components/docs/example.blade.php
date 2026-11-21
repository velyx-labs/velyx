@props([
    'name',
    'stage' => 'min-h-[260px]',
])

{{--
    Renders resources/views/docs/examples/{name}.blade.php live with the real
    x-ui components, inside the component theme, and shows that same file as
    the code below it.
--}}
@php
    $view = 'docs.examples.'.$name;
    $source = \App\Docs\Highlighter::dedent(file_get_contents(resource_path('views/docs/examples/'.str_replace('.', '/', $name).'.blade.php')));
    $collapsible = substr_count($source, "\n") >= 3;
@endphp

<section aria-label="Preview" {{ $attributes->class('overflow-hidden rounded-xl border border-border bg-surface') }} x-data="{ open: false }">
    <div class="velyx-preview relative grid place-items-center bg-[radial-gradient(var(--velyx-border)_1px,transparent_1px)] bg-size-[16px_16px] px-6 py-10 {{ $stage }}">
        <div class="flex w-full flex-wrap items-center justify-center gap-3">
            @include($view)
        </div>
    </div>

    <div class="relative border-t border-border">
        @if ($collapsible)
            <div x-bind:class="open ? '' : 'max-h-[120px] overflow-hidden'">
                <x-docs.code :code="$source" :numbers="false" class="rounded-none border-0" />
            </div>
            <div x-show="! open" class="pointer-events-none absolute inset-x-0 bottom-0 h-[84px] bg-linear-to-b from-transparent to-[#f6f7f8] dark:to-surface"></div>
            <div x-bind:class="open ? 'relative pb-4' : 'absolute inset-x-0 bottom-3'" class="flex justify-center">
                <button
                    type="button"
                    x-on:click="open = ! open"
                    x-bind:aria-expanded="open"
                    class="h-[30px] rounded-md border border-border bg-surface px-3.5 text-small font-medium text-ink shadow-xs hover:bg-surface-subtle"
                    x-text="open ? 'Hide code' : 'View code'"
                >View code</button>
            </div>
        @else
            <x-docs.code :code="$source" :numbers="false" class="rounded-none border-0" />
        @endif
    </div>
</section>
