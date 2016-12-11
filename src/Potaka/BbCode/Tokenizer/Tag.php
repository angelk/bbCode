<?php

namespace Potaka\BbCode\Tokenizer;

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
class Tag
{
    /**
     * @var Tag[]
     */
    private $tags = [];
    private $type;
    private $parent = null;
    private $text;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return Tag|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(Tag $parent)
    {
        $this->parent = $parent;
    }

    public function addTag(Tag $tag)
    {
        $tag->setParent($this);
        $this->tags[] = $tag;

        return $this;
    }

    public function removeTag($tagToRemove)
    {
        foreach ($this->tags as $tagkey => $tag) {
            if ($tag === $tagToRemove) {
                unset($this->tags[$tagkey]);
                return true;
            }
        }

        return false;
    }

    /**
     *
     * @param bool $reverse
     * @return Tag[]
     */
    public function getTags($reverse = false)
    {
        if ($reverse) {
            return array_reverse($this->tags);
        }

        return $this->tags;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
}
