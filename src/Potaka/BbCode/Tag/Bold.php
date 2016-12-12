<?php

namespace Potaka\BbCode\Tag;

/**
 * Description of bold
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Bold extends SimpleTag
{

    public function getCloseHtmlTag(): string
    {
        return '</b>';
    }

    public function getOpenHtmlTag(): string
    {
        return '<b>';
    }

    public function getTag() : string
    {
        return 'b';
    }
}
