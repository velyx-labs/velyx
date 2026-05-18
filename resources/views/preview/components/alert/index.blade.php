@props([
    'props' => [],
])
@php
    $variant = (string) ($props['variant'] ?? 'default');
    $title   = (string) ($props['title'] ?? 'Update available');
    $message = (string) ($props['message'] ?? 'A new version is available. Please update to get the latest improvements.');

    $icons = [
        'destructive' => 'lucide-circle-alert',
        'success'     => 'lucide-circle-check',
        'warning'     => 'lucide-triangle-alert',
        'info'        => 'lucide-info',
        'default'     => 'lucide-info',
    ];
    $icon = $icons[$variant] ?? 'lucide-info';
@endphp

<div class="preview relative flex h-[200px] w-full items-start justify-center p-6 [&_[role=alert]]:max-w-lg">
    <x-ui.alert :variant="$variant">
        <x-dynamic-component :component="$icon" />
        <x-ui.alert.title>{{ $title }}</x-ui.alert.title>
        <x-ui.alert.description>{{ $message }}</x-ui.alert.description>
    </x-ui.alert>
</div>
