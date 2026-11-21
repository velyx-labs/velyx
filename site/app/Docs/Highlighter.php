<?php

namespace App\Docs;

/**
 * A small, dependency-free highlighter for the languages the docs show:
 * Blade and HTML, PHP, JSON, CSS and shell. Tokens map to .tok-* classes
 * styled in resources/css/docs.css.
 */
class Highlighter
{
    private const TOKENS = '~'
        .'(?P<com>//.*$|/\*.*?\*/|\{\{--.*?--\}\}|<!--.*?-->|(?<![\w$])#\s.*$)'
        .'|(?P<key>"[^"\n]*"(?=\s*:))'
        .'|(?P<str>"[^"\n]*"|\'[^\'\n]*\')'
        .'|(?P<tag></?x-[\w.:-]+|</?[a-z][\w-]*(?=[\s>/])|/?>)'
        .'|(?P<dir>@[a-zA-Z]+|\{\{|\}\}|\{!!|!!\})'
        .'|(?P<attr>(?<=\s)[:@]?[\w.:-]+(?==))'
        .'|(?P<var>\$\w+|--[\w-]+)'
        .'|(?P<kw>\b(?:public|private|protected|function|bool|void|string|int|array|return|false|true|null|class|use|namespace|new|extends|static|fn|if|else|foreach|as)\b)'
        .'|(?P<fn>\b[\w-]+(?=\())'
        .'|(?P<num>\b\d+(?:\.\d+)?(?:px|rem|%)?\b)'
        .'|(?P<pun>->|=>|::|[{}()\[\];,=:])'
        .'~m';

    /**
     * Highlight a code sample and return one HTML string per line.
     *
     * @return list<string>
     */
    public function lines(string $code): array
    {
        $code = str_replace("\r\n", "\n", rtrim($code, "\n"));

        return array_map(fn (string $line): string => $this->line($line), explode("\n", $code));
    }

    /**
     * Remove the indentation shared by every non-empty line, and blank edges.
     */
    public static function dedent(string $code): string
    {
        $lines = explode("\n", str_replace("\r\n", "\n", $code));

        while ($lines !== [] && trim($lines[0]) === '') {
            array_shift($lines);
        }

        while ($lines !== [] && trim(end($lines)) === '') {
            array_pop($lines);
        }

        $indentOf = fn (string $line): int => strlen($line) - strlen(ltrim($line, ' '));

        // Blade trims component slots, so the first line may have lost its indentation.
        $measured = count($lines) > 1 && $indentOf($lines[0]) === 0 ? array_slice($lines, 1) : $lines;

        $indent = collect($measured)
            ->filter(fn (string $line): bool => trim($line) !== '')
            ->map($indentOf)
            ->min() ?? 0;

        return implode("\n", array_map(
            fn (string $line): string => substr($line, min($indent, $indentOf($line))),
            $lines,
        ));
    }

    public function line(string $line): string
    {
        $html = '';
        $position = 0;

        preg_match_all(self::TOKENS, $line, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE | PREG_UNMATCHED_AS_NULL);

        foreach ($matches as $match) {
            [$text, $offset] = $match[0];
            $type = $this->typeOf($match);

            $html .= e(substr($line, $position, $offset - $position));
            $html .= '<span class="tok-'.$type.'">'.e($text).'</span>';
            $position = $offset + strlen($text);
        }

        return $html.e(substr($line, $position));
    }

    /**
     * @param  array<int|string, array{0: ?string, 1: int}>  $match
     */
    private function typeOf(array $match): string
    {
        foreach ($match as $group => $value) {
            if (is_string($group) && $value[0] !== null) {
                return $group;
            }
        }

        return 'pun';
    }
}
