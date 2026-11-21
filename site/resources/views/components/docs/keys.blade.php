@props([
    'rows',
])

{{-- rows: [key => action] --}}
<div class="overflow-x-auto rounded-lg border border-border bg-surface">
    <table class="w-full border-collapse text-left text-control">
        <thead class="border-b border-border bg-surface-subtle">
            <tr>
                <th scope="col" class="px-4 py-2.5 font-mono text-label font-medium tracking-[0.06em] text-ink-subtle uppercase">Key</th>
                <th scope="col" class="px-4 py-2.5 font-mono text-label font-medium tracking-[0.06em] text-ink-subtle uppercase">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $key => $action)
                <tr class="border-t border-border first:border-t-0">
                    <td class="px-4 py-[11px] align-top"><x-site.kbd>{{ $key }}</x-site.kbd></td>
                    <td class="px-4 py-[11px] align-top text-ink-muted">{{ $action }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
