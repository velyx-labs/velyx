<div
    data-slot="table-container"
    class="relative w-full overflow-x-auto scrollbar-thin scrollbar-thumb-muted/60 scrollbar-track-muted/10"
>
    <table
        data-slot="table"
        {{ $attributes->class(['w-full caption-bottom text-sm']) }}
    >{{ $slot }}</table>
</div>
