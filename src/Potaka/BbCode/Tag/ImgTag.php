<?php

namespace Potaka\BbCode\Tag;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 * ImgTag
 *
 * Handle [img] tag
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class ImgTag implements TagInterface
{
    public function format(TokenTag $tokenTag): string
    {
        $link = $tokenTag->getText();
        if (!preg_match('!^https?://[a-z0-9\-@:.,_&+%#?/=]+$!i', $link)) {
            $unknownTag = new UnknownSimpleType();
            return $unknownTag->format($tokenTag);
        }

        return '<img src="' . $link . '" />';
    }

    public function getName(): string
    {
        return 'img';
    }

    public function getOriginalText(TokenTag $tokenTag): string
    {
        return "[{$this->getName()}]{$tokenTag->getText()}[/{$this->getName()}";
    }
}
