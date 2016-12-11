<?php

namespace Potaka\BbCode\Tag;

/**
 * Description of Italic
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Italic extends SimpleTag
{
    public function getCloseHtmlTag() : string
    {
        return '</i>';
    }

    public function getOpenHtmlTag() : string
    {
        return '<i>';
    }

    public function getTag(): string
    {
        return 'i';
    }
}
