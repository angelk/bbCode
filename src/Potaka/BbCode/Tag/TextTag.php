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
        // @TODO! This is wrong. We need the tagname!
        return $string;
    }

    public function getName(): string
    {
        return 'text';
    }
}
