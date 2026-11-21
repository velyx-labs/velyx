<x-ui.card class="w-full max-w-sm">
    <x-ui.card.header>
        <x-ui.card.title>Create project</x-ui.card.title>
        <x-ui.card.description>Deploy a new Laravel app in one click.</x-ui.card.description>
    </x-ui.card.header>
    <x-ui.card.content class="flex flex-col gap-2">
        <x-ui.label for="card-name">Name</x-ui.label>
        <x-ui.input id="card-name" value="billing-api" />
    </x-ui.card.content>
    <x-ui.card.footer class="justify-between">
        <x-ui.button variant="outline">Cancel</x-ui.button>
        <x-ui.button>Create</x-ui.button>
    </x-ui.card.footer>
</x-ui.card>
