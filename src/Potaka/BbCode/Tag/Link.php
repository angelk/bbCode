<?php

namespace Potaka\BbCode\Tag;

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
class Link implements TagInterface
{
    const REG_EXP_VALID_URL = 'https?://[a-zA-Z0-9_\-.:/#?]+';
    const REG_EXP_VALID_NAME = '[^\[]+';

    public function format(string $string): string
    {
        $pattern  = '\[url=(' . self::REG_EXP_VALID_URL . ')\](' . self::REG_EXP_VALID_NAME . ')\[/url\]';
        return preg_replace(
            "~{$pattern}~",
            '<a href="$1">$2</a>',
            $string
        );
    }

    public function getName(): string
    {
        return 'url';
    }
}
