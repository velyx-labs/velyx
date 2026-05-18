@props([
    'props' => [],
])

<div class="preview relative w-full p-6" style="min-height: 420px;">
    <div class="max-w-sm">
        <x-ui.date-picker
            placeholder="Pick a date"
            :clearable="true"
        />
    </div>
</div>
