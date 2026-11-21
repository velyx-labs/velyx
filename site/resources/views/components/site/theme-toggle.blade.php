<button
    type="button"
    x-data="{
        dark: document.documentElement.classList.contains('dark'),
        toggle() {
            this.dark = ! this.dark;
            document.documentElement.classList.toggle('dark', this.dark);
            document.documentElement.classList.toggle('light', ! this.dark);
            try { localStorage.setItem('theme', this.dark ? 'dark' : 'light'); } catch (e) {}
        },
    }"
    x-on:click="toggle()"
    x-bind:aria-pressed="dark"
    {{ $attributes->class('inline-flex size-[34px] items-center justify-center rounded-md text-ink hover:bg-surface-subtle hover:text-ink') }}
>
    <x-tabler-moon class="size-4 dark:hidden" aria-hidden="true" />
    <x-tabler-sun class="hidden size-4 dark:block" aria-hidden="true" />
    <span class="sr-only">Toggle dark mode</span>
</button>
