<?php

namespace Tests\Unit;

use App\Docs\Highlighter;
use PHPUnit\Framework\TestCase;

class HighlighterTest extends TestCase
{
    public function test_it_highlights_blade_and_escapes_html(): void
    {
        $html = (new Highlighter)->line('<x-ui.button variant="outline">Go</x-ui.button>');

        $this->assertSame(
            '<span class="tok-tag">&lt;x-ui.button</span> <span class="tok-attr">variant</span><span class="tok-pun">=</span>'
            .'<span class="tok-str">&quot;outline&quot;</span><span class="tok-tag">&gt;</span>Go<span class="tok-tag">&lt;/x-ui.button</span><span class="tok-tag">&gt;</span>',
            $html,
        );
    }

    public function test_it_highlights_php_and_json(): void
    {
        $highlighter = new Highlighter;

        $this->assertStringContainsString('<span class="tok-kw">public</span>', $highlighter->line('public function deploy(): void'));
        $this->assertStringContainsString('<span class="tok-var">$this</span>', $highlighter->line('$this->deploy();'));
        $this->assertStringContainsString('<span class="tok-key">&quot;icons&quot;</span>', $highlighter->line('"icons": "lucide"'));
    }

    public function test_dedent_handles_slots_whose_first_line_was_trimmed(): void
    {
        $this->assertSame(
            "<a>\n    <b />\n</a>",
            Highlighter::dedent("<a>\n                    <b />\n                </a>\n"),
        );
    }
}
