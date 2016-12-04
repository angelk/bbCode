<?php

namespace Potaka\BbCode\Tag;

/**
 * Description of bold
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Bold extends SimpleTag {

    public function getCloseHtmlTag() {
        return '</b>';
    }

    public function getClosetag() {
        return '[/b]';
    }

    public function getOpenHtmlTag() {
        return '<b>';
    }

    public function getOpentag() {
        return '[b]';
    }

}
