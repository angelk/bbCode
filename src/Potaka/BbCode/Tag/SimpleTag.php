<?php

namespace Potaka\BbCode\Tag;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
abstract class SimpleTag implements TagInterface
{
    public function format(TokenTag $tokenTag) : string
    {
        $formattedString = "{$this->getOpenHtmlTag()}{$tokenTag->getText()}{$this->getCloseHtmlTag()}";
        return $formattedString;
    }

    abstract public function getTag() : string;

    public function getName() : string
    {
        return $this->getTag();
    }

    abstract public function getOpenHtmlTag() : string;

    abstract public function getCloseHtmlTag() : string;
}
