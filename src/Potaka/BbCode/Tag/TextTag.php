<?php

namespace Potaka\BbCode\Tag;

/**
 * Description of TextTag
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class TextTag implements TagInterface
{
    public function format(string $string): string
    {
        return $string;
    }
}
