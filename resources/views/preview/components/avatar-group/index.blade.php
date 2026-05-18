@props([
    'props' => [],
])

<div class="preview relative flex h-[220px] w-full items-center justify-center p-6">
    <div class="flex flex-col items-center gap-4">
        <x-ui.avatar-group>
            @foreach([
                ['img=11', 'Jane Cooper'],
                ['img=12', 'Devon Lane'],
                ['img=13', 'Robert Fox'],
                ['img=14', 'Wade Warren'],
            ] as [$img, $name])
                <x-ui.avatar>
                    <x-ui.avatar.image src="https://i.pravatar.cc/80?{{ $img }}" alt="{{ $name }}" />
                    <x-ui.avatar.fallback>{{ substr($name, 0, 2) }}</x-ui.avatar.fallback>
                </x-ui.avatar>
            @endforeach
            <x-ui.avatar-group.count>+3</x-ui.avatar-group.count>
        </x-ui.avatar-group>
        <p class="text-xs text-muted-foreground">Team members</p>
    </div>
</div>
