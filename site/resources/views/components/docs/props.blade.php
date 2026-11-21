@props([
    'name',
    'rows',
])

{{-- rows: list of [prop, type, default, description] --}}
<div class="flex flex-col gap-3">
    <h3 class="m-0 font-mono text-[15px] font-medium text-ink">{{ $name }}</h3>
    <div class="overflow-x-auto rounded-lg border border-border bg-surface">
        <table class="w-full border-collapse text-left text-control">
            <thead class="border-b border-border bg-surface-subtle">
                <tr>
                    @foreach (['Prop', 'Type', 'Default', 'Description'] as $heading)
                        <th scope="col" class="px-4 py-2.5 font-mono text-label font-medium tracking-[0.06em] text-ink-subtle uppercase">{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as [$prop, $type, $default, $description])
                    <tr class="border-t border-border first:border-t-0">
                        <td class="px-4 py-[11px] align-top"><code class="rounded-sm border border-border bg-surface-subtle px-[5px] py-px font-mono text-code-inline text-ink">{{ $prop }}</code></td>
                        <td class="px-4 py-[11px] align-top font-mono text-xs text-ink-muted">{{ $type }}</td>
                        <td class="px-4 py-[11px] align-top font-mono text-xs text-ink-muted">{{ $default }}</td>
                        <td class="px-4 py-[11px] align-top text-ink-muted">{{ $description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
