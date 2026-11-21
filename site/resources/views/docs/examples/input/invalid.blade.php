<div class="flex w-full max-w-sm flex-col gap-2">
    <x-ui.label for="contact">Email</x-ui.label>
    <x-ui.input id="contact" value="not-an-email" :invalid="true" aria-describedby="contact-error" />
    <p id="contact-error" class="text-sm text-destructive">Enter a valid email address.</p>
</div>
