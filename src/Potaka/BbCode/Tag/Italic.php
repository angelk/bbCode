<?php

namespace Potaka\BbCode\Tag;

/**
 * Description of Italic
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Italic extends SimpleTag
{
    public function getCloseHtmlTag()
    {
        return '</i>';
    }

    public function getClosetag()
    {
        return '[/i]';
    }

    public function getOpenHtmlTag()
    {
        return '<i>';
    }

    public function getOpentag()
    {
        return '[i]';
    }
}
