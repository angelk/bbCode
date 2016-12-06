<?php

namespace Potaka\BbCode;

use Potaka\BbCode\Tag\TagInterface;

/**
 * Description of bbCode
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class BbCode
{
    /**
     * @var TagInterface[]
     */
    protected $tags = array();

    public function addTag(TagInterface $tag) : self
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @return TagInterface[]
     */
    public function getTags() : array
    {
        return $this->tags;
    }
}
