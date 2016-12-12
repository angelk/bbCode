<?php

namespace Potaka\BbCode\Tag;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
interface TagInterface
{
    public function format(TokenTag $tokenTag) : string;

    public function getName() : string;
}
