<?php

namespace Potaka\BbCode;

use Potaka\BbCode\Tag\Bold;
use Potaka\BbCode\Tag\Underline;
use Potaka\BbCode\Tag\Italic;

/**
 * Description of Factory
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Factory
{
    /**
     * @return BbCode
     */
    public function getFullBbCode()
    {
        $bbcode = new BbCode();
        $bbcode->addTag(new Bold());
        $bbcode->addTag(new Underline());
        $bbcode->addTag(new Italic());
        return $bbcode;
    }
}