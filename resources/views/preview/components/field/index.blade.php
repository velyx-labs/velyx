@props([
    'props' => [],
])

<div class="preview w-full p-8">
    <div class="mx-auto w-full max-w-sm space-y-5">
        <x-ui.field>
            <x-ui.field.label for="preview-field-name" required>Full name</x-ui.field.label>
            <x-ui.field.content>
                <x-ui.input id="preview-field-name" placeholder="John Doe" />
            </x-ui.field.content>
            <x-ui.field.description>Your legal name as it appears on your ID.</x-ui.field.description>
        </x-ui.field>

        <x-ui.field>
            <x-ui.field.label for="preview-field-email" required>Email address</x-ui.field.label>
            <x-ui.field.content>
                <x-ui.input id="preview-field-email" type="email" placeholder="you@example.com" />
            </x-ui.field.content>
        </x-ui.field>

        <x-ui.field>
            <x-ui.field.label for="preview-field-bio">Bio</x-ui.field.label>
            <x-ui.field.content>
                <x-ui.input id="preview-field-bio" placeholder="Tell us about yourself..." />
            </x-ui.field.content>
            <x-ui.field.description>Max 160 characters.</x-ui.field.description>
        </x-ui.field>
    </div>
</div>
