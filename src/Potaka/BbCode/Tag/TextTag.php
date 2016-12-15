<?php

namespace Potaka\BbCode\Tag;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 * Description of TextTag
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class TextTag implements TagInterface
{
    public function format(TokenTag $tokenTag) : string
    {
        $formattedString = "{$tokenTag->getText()}";
        return $formattedString;
    }

    public function getName(): string
    {
        return '';
    }

    public function getOriginalText(TokenTag $tokenTag): string
    {
        // there is nothing special
        return $this->format($tokenTag);
    }
}
