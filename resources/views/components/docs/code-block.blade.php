@props([
    'language' => null,
])

<div {{ $attributes->merge(['class' => 'group relative']) }}>
    <button
        x-data="codeCopy()"
        @click="copyToClipboard($el)"
        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity p-2 rounded-md bg-muted hover:bg-muted-foreground/20 text-muted-foreground hover:text-foreground"
        title="Copy code"
    >
        <x-lucide-copy class="w-4 h-4" />
        <span x-show="copied" class="absolute -bottom-8 left-1/2 -translate-x-1/2 text-xs bg-foreground text-background px-2 py-1 rounded whitespace-nowrap">Copied!</span>
    </button>

    {{ $slot }}
</div>

<script>
function codeCopy() {
    return {
        copied: false,
        async copyToClipboard(button) {
            const codeBlock = button.nextElementSibling;
            const code = codeBlock.querySelector('code');
            const text = code.textContent;

            try {
                await navigator.clipboard.writeText(text);
                this.copied = true;
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            } catch (err) {
                console.error('Failed to copy:', err);
            }
        }
    }
}
</script>
