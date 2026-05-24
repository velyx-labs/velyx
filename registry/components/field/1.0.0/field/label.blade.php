@props(['for' => null, 'required' => false, 'hint' => null])

<label
    data-slot="field-label"
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->class([
        'group/field-label peer/field-label flex w-fit gap-2 leading-snug',
        'group-data-[disabled=true]/field:opacity-50',
        'has-data-checked:border-primary/30 has-data-checked:bg-primary/5',
        'dark:has-data-checked:border-primary/20 dark:has-data-checked:bg-primary/10',
        'has-[>[data-slot=field]]:rounded-lg has-[>[data-slot=field]]:border has-[>[data-slot=field]]:w-full has-[>[data-slot=field]]:flex-col',
        '*:data-[slot=field]:p-2.5',
    ]) }}
>
    {{ $slot }}
    @if($required)
        <span aria-hidden="true" class="text-destructive">*</span>
    @endif
    @if($hint)
        <span class="font-normal text-muted-foreground">({{ $hint }})</span>
    @endif
</label>
