@props([
    'props' => [],
])
@php
    $src  = $props['src'] ?? null;
    $name = (string) ($props['name'] ?? 'Jane Cooper');
    $size = (string) ($props['size'] ?? 'default');
@endphp

<div class="preview relative flex h-[220px] w-full items-center justify-center p-6">
    <div class="flex items-center gap-6">
        <x-ui.avatar size="sm">
            @if($src)<x-ui.avatar.image src="{{ $src }}" alt="{{ $name }}" />@endif
            <x-ui.avatar.fallback>{{ strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(preg_split('/\s+/', trim($name)), 0, 2)))) }}</x-ui.avatar.fallback>
        </x-ui.avatar>
        <x-ui.avatar :size="$size">
            @if($src)<x-ui.avatar.image src="{{ $src }}" alt="{{ $name }}" />@endif
            <x-ui.avatar.fallback>{{ strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(preg_split('/\s+/', trim($name)), 0, 2)))) }}</x-ui.avatar.fallback>
        </x-ui.avatar>
        <x-ui.avatar size="lg">
            @if($src)<x-ui.avatar.image src="{{ $src }}" alt="{{ $name }}" />@endif
            <x-ui.avatar.fallback>{{ strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), array_slice(preg_split('/\s+/', trim($name)), 0, 2)))) }}</x-ui.avatar.fallback>
        </x-ui.avatar>
        <p class="text-sm font-medium text-foreground">{{ $name }}</p>
    </div>
</div>
