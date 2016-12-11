<?php

namespace Potaka\BbCode\Tag;

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
abstract class SimpleTag implements TagInterface
{
    public function format(string $string) : string
    {
        $formattedString = "{$this->getOpenHtmlTag()}{$string}{$this->getCloseHtmlTag()}";
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
