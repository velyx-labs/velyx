@props([
    'group',
    'examples',
])

{{-- examples: [key => title] or [key => [title, html description]]; each key is a file in docs/examples/{group}/ --}}
@foreach ($examples as $key => $example)
    @php
        [$exampleTitle, $exampleText] = is_array($example) ? [$example[0], $example[1] ?? null] : [$example, null];
    @endphp
    <x-docs.section :id="$key" :title="$exampleTitle">
        @if ($exampleText)
            <p class="docs-prose">{!! $exampleText !!}</p>
        @endif
        <x-docs.example :name="$group.'.'.$key" stage="min-h-[180px]" />
    </x-docs.section>
@endforeach
