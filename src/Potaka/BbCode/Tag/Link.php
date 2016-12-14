<?php

namespace Potaka\BbCode\Tag;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
class Link implements TagInterface
{
    const REG_EXP_VALID_URL = '~https?://[a-zA-Z0-9_\-.:/#?]+~';

    public function format(TokenTag $tokenTag): string
    {
        $url = $tokenTag->getArgument();

        if (!preg_match(self::REG_EXP_VALID_URL, $url)) {
            $simpleTag = new UnknownSimpleType();
            return $simpleTag->format($tokenTag);
        }

        return "<a href=\"{$url}\" target=\"_blank\">{$tokenTag->getText()}</a>";
    }

    public function getName(): string
    {
        return 'url';
    }

    public function getOriginalText(TokenTag $tokenTag) : string
    {
        throw new Exception("Not implemented");
        return "[url={$tokenTag->getArgument()}]{$tokenTag->getText()}[/url]";
    }
}
