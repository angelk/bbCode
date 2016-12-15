<?php

namespace Potaka\BbCode\TagBag;

use Potaka\BbCode\Tag\TagInterface;

/**
 * Container for Tags
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class TagBag
{
    /**
     * @var TagInterface[]
     */
    private $tags = [];

    /**
     * @param TagInterface[] $tags
     */
    public function __construct(array $tags = [])
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    public function addTag(TagInterface $tag)
    {
        $this->tags[] = $tag;
    }

    public function contains(TagInterface $tagTocheck)
    {
        foreach ($this->tags as $tag) {
            if ($tag === $tagTocheck) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return intersection with given tags
     *
     * @param array $tags
     * @return self
     */
    public function intersect(array $tags)
    {
        $result = new self();
        foreach ($tags as $tag) {
            if ($this->contains($tag)) {
                $result->addTag($tag);
            }
        }

        return $result;
    }
}
