<?php

namespace Potaka\BbCode\Tag;

/**
 * @author po_taka
 */
class Underline extends SimpleTag
{
    public function getTag() : string
    {
        return 'u';
    }

    public function getOpenHtmlTag() : string
    {
        return '<u>';
    }

    public function getCloseHtmlTag() : string
    {
        return '</u>';
    }
}
