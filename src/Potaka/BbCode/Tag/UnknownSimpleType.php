<?php

namespace Potaka\BbCode\Tag;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 * Description of UnknownSimpleType
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class UnknownSimpleType implements TagInterface
{
    public function format(TokenTag $tokenTag) : string
    {
        $formattedString = "[{$tokenTag->getType()}";

        if ($tokenTag->getArgument()) {
            $formattedString .= "={$tokenTag->getArgument()}";
        }

        $formattedString .= "]{$tokenTag->getText()}[/{$tokenTag->getType()}]";
        return $formattedString;
    }

    public function getName(): string
    {
        return '';
    }

    public function getOriginalText(TokenTag $tokenTag): string
    {
        return "[{$tokenTag->getType()}]{$tokenTag->getText()}[/{$tokenTag->getType()}]";
    }
}
