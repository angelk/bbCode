<?php

namespace Potaka\BbCode;

use Potaka\BbCode\Tag\TagInterface;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

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
    protected $tags = [];
    private $tokenCacheMap = [];

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

    public function format(TokenTag $text) : string
    {
        foreach ($this->getTags() as $tag) {
            $text = $tag->format($text);
        }

        return $text;
    }

    private function getBbCodeTagFromTokenTag(TokenTag $tokenTag) : TagInterface
    {
        if (array_key_exists($tokenTag->getType(), $this->tags)) {
            return $this->tags[$tokenTag];
        }

        foreach ($this->tags as $tag) {
            if ($tag->getName() === $tokenTag->getType()) {
                $this->tokenCacheMap[$tokenTag->getType()] = $tag;
                return $tag;
            }
        }

        $textTag = new Tag\TextTag();
        $this->tokenCacheMap[$tokenTag->getType()] = $textTag;
        return $textTag;
    }
}
