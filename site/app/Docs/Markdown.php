<?php

namespace App\Docs;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;
use Illuminate\Contracts\View\View;

/**
 * Turns a rendered docs page into Markdown, for "Copy page" and the .md
 * URLs. It reads the page's <article>, keeps headings, prose, lists, tables
 * and code, and drops what only makes sense on screen: live previews,
 * buttons, icons and anything marked data-md="skip".
 *
 * Code blocks come from data-md-code, so the Markdown gets the exact source
 * rather than the highlighted HTML.
 */
class Markdown
{
    /** Marks list indentation until the end, so the line cleanup keeps it. */
    private const INDENT = "\x01";

    /** @var list<array{code: string, lang: string}> */
    private array $code = [];

    public function fromView(View $view): string
    {
        return $this->fromHtml($view->render());
    }

    public function fromHtml(string $html): string
    {
        $this->code = [];

        $document = new DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8"?>'.$html, LIBXML_NOERROR | LIBXML_NOWARNING);

        $article = (new DOMXPath($document))->query('//article')->item(0);

        if (! $article instanceof DOMElement) {
            return '';
        }

        return $this->finish($this->children($article));
    }

    private function node(DOMNode $node): string
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            return preg_replace('/\s+/u', ' ', $node->textContent);
        }

        if (! $node instanceof DOMElement || $this->skipped($node)) {
            return '';
        }

        if ($node->hasAttribute('data-md-code')) {
            $info = trim($node->getAttribute('data-md-lang').($node->hasAttribute('data-md-title') ? ' title="'.$node->getAttribute('data-md-title').'"' : ''));

            return $this->block($this->codeToken($node->getAttribute('data-md-code'), $info));
        }

        return match ($node->tagName) {
            'h1', 'h2', 'h3', 'h4' => $this->block(str_repeat('#', (int) $node->tagName[1]).' '.$this->inline($node)),
            'p' => $this->block($this->inline($node)),
            'pre' => $this->block($this->codeToken(rtrim($node->textContent), '')),
            'ul', 'ol' => $this->block($this->list($node)),
            'table' => $this->block($this->table($node)),
            'br' => "\n",
            'code' => '`'.trim($node->textContent).'`',
            'strong', 'b' => '**'.trim($this->children($node)).'**',
            'em', 'i' => '_'.trim($this->children($node)).'_',
            'a' => $this->link($node),
            default => $this->children($node),
        };
    }

    private function children(DOMNode $node): string
    {
        $out = '';

        foreach ($node->childNodes as $child) {
            $out .= $this->node($child);
        }

        return $out;
    }

    private function inline(DOMNode $node): string
    {
        return trim(preg_replace('/[ \t]+/', ' ', str_replace("\n", ' ', $this->children($node))));
    }

    private function block(string $text): string
    {
        $text = trim($text);

        return $text === '' ? '' : "\n\n".$text."\n\n";
    }

    private function link(DOMElement $node): string
    {
        $text = trim($this->children($node));
        $href = $node->getAttribute('href');

        if ($text === '' || $href === '' || str_starts_with($href, '#')) {
            return $text;
        }

        return '['.$text.']('.$href.')';
    }

    private function list(DOMElement $list): string
    {
        $items = [];
        $number = 0;

        foreach ($list->childNodes as $item) {
            if (! $item instanceof DOMElement || $item->tagName !== 'li' || $this->skipped($item)) {
                continue;
            }

            $marker = $list->tagName === 'ol' ? (++$number).'. ' : '- ';
            $lines = explode("\n", $this->tidy($this->children($item)));
            $indent = str_repeat(self::INDENT, strlen($marker));

            $items[] = $marker.implode("\n", array_map(
                fn (string $line, int $i): string => $i === 0 || $line === '' ? $line : $indent.$line,
                $lines,
                array_keys($lines),
            ));
        }

        $loose = collect($items)->contains(fn (string $item): bool => str_contains($item, "\n"));

        return implode($loose ? "\n\n" : "\n", $items);
    }

    private function table(DOMElement $table): string
    {
        $rows = [];

        foreach ((new DOMXPath($table->ownerDocument))->query('.//tr', $table) as $tr) {
            $cells = [];

            foreach ($tr->childNodes as $cell) {
                if ($cell instanceof DOMElement && in_array($cell->tagName, ['td', 'th'], true)) {
                    $cells[] = str_replace('|', '\|', $this->inline($cell));
                }
            }

            if ($cells !== []) {
                $rows[] = $cells;
            }
        }

        if ($rows === []) {
            return '';
        }

        $width = max(array_map('count', $rows));
        $line = fn (array $cells): string => '| '.implode(' | ', array_pad($cells, $width, '')).' |';

        // Tables without a header row still need one in Markdown.
        $hasHeader = (new DOMXPath($table->ownerDocument))->query('.//th', $table)->length > 0;
        $header = $hasHeader ? array_shift($rows) : array_fill(0, $width, ' ');

        return implode("\n", [
            $line($header),
            '| '.implode(' | ', array_fill(0, $width, '---')).' |',
            ...array_map($line, $rows),
        ]);
    }

    private function codeToken(string $code, string $lang): string
    {
        $this->code[] = ['code' => trim($code, "\n"), 'lang' => $lang];

        return "\x02".(count($this->code) - 1)."\x02";
    }

    private function skipped(DOMElement $node): bool
    {
        return in_array($node->tagName, ['button', 'svg', 'script', 'style', 'template', 'nav', 'aside'], true)
            || $node->getAttribute('aria-hidden') === 'true'
            || $node->getAttribute('data-md') === 'skip'
            || $node->getAttribute('role') === 'tablist'
            || str_contains(' '.$node->getAttribute('class').' ', ' sr-only ');
    }

    /**
     * Trims every line and collapses blank runs, leaving list indents and
     * code tokens alone.
     */
    private function tidy(string $text): string
    {
        $lines = array_map(fn (string $line): string => trim($line, " \t"), explode("\n", $text));

        return trim(preg_replace("/\n{3,}/", "\n\n", implode("\n", $lines)));
    }

    private function finish(string $text): string
    {
        $text = $this->tidy($text);

        $text = preg_replace_callback("/^([\x01]*)\x02(\d+)\x02$/m", function (array $match): string {
            $block = $this->code[(int) $match[2]];
            $fence = str_contains($block['code'], '```') ? '````' : '```';
            $indent = $match[1];

            return collect([$fence.$block['lang'], ...explode("\n", $block['code']), $fence])
                ->map(fn (string $line): string => $line === '' ? $line : $indent.$line)
                ->implode("\n");
        }, $text);

        return str_replace(self::INDENT, ' ', $text)."\n";
    }
}
