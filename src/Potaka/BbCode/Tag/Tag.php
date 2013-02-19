<?php

namespace Potaka\BbCode\Tag;

/**
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
interface Tag {

    public function format($string);

    public function getOpentag();
}
