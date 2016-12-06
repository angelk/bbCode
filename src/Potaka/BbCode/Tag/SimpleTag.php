<?php

namespace Potaka\BbCode\Tag;

/**
 * Description of SimpleTag
 *
 * @author po_taka <angel.koilov@gmail.com
 */
abstract class SimpleTag implements TagInterface
{
    public function format($string) : string
    {
        $string = (string) $string;
        $openTag = preg_quote($this->getOpenTag(), '#');
        $closeTag = preg_quote($this->getClosetag(), '#');
        $formattedString = preg_replace("#{$openTag}(.*?){$closeTag}#", "{$this->getOpenHtmlTag()}$1{$this->getCloseHtmlTag()}", $string);
        if ($formattedString === null) {
            throw new Exception("{$string} regexp failed");
        }

        return $formattedString;
    }

    abstract public function getOpenTag() : string;

    abstract public function getClosetag() : string;

    abstract public function getOpenHtmlTag() : string;

    abstract public function getCloseHtmlTag() : string;
}
