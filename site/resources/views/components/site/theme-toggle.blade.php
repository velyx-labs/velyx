{{-- Light/dark switch: a half-filled circle, a cross-fade through the View
     Transitions API where the browser has it, and "D" as a shortcut. --}}
<button
    type="button"
    x-data="{
        dark: document.documentElement.classList.contains('dark'),
        apply() {
            this.dark = ! this.dark;
            document.documentElement.classList.toggle('dark', this.dark);
            document.documentElement.classList.toggle('light', ! this.dark);
            try { localStorage.setItem('theme', this.dark ? 'dark' : 'light'); } catch (e) {}
        },
        toggle() {
            const still = matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (! document.startViewTransition || still) return this.apply();
            document.startViewTransition(() => this.apply());
        },
        shortcut(event) {
            if (event.key.toLowerCase() !== 'd' || event.metaKey || event.ctrlKey || event.altKey || event.repeat) return;
            const target = event.target;
            if (target.isContentEditable || ['INPUT', 'TEXTAREA', 'SELECT'].includes(target.tagName)) return;
            event.preventDefault();
            this.toggle();
        },
    }"
    x-on:click="toggle()"
    x-on:keydown.window="shortcut($event)"
    x-bind:aria-pressed="dark"
    title="Toggle theme (D)"
    {{ $attributes->class('group/theme inline-flex size-8 items-center justify-center rounded-md text-ink transition-colors hover:bg-surface-subtle active:scale-95') }}
>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-[18px] transition-transform duration-300 ease-out dark:rotate-180" aria-hidden="true">
        <circle cx="12" cy="12" r="9" />
        <path d="M12 3v18a9 9 0 0 0 0-18Z" fill="currentColor" stroke="none" />
    </svg>
    <span class="sr-only">Toggle theme</span>
</button>
