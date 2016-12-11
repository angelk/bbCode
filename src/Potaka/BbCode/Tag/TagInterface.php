<?php

namespace Potaka\BbCode\Tag;

/**
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
interface TagInterface
{
    public function format(string $string) : string;

    public function getName() : string;
}
