<?php

namespace Potaka\BbCode;

use Potaka\BbCode\Tag\TagInterface;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

use Potaka\BbCode\Tag\TextTag;
use Potaka\BbCode\Tag\UnknownSimpleType;

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

    public function format(TokenTag $tokenRootTag) : string
    {
        $text = '';
        foreach ($tokenRootTag->getTags() as $tokenTag) {
            $text .= $this->format($tokenTag);
        }

        $tmpTag = clone $tokenRootTag;
        $tmpTag->setText($text . $tokenRootTag->getText());
        $currentBbCodeType = $this->getBbCodeTagFromTokenTag($tokenRootTag);
        $textFormatted = $currentBbCodeType->format($tmpTag);

        return $textFormatted;
    }

    private function getBbCodeTagFromTokenTag(TokenTag $tokenTag) : TagInterface
    {
        if (array_key_exists($tokenTag->getType(), $this->tags)) {
            return new $this->tokenCacheMap[$tokenTag];
        }

        foreach ($this->tags as $tag) {
            if ($tag->getName() === $tokenTag->getType()) {
                $this->tokenCacheMap[$tokenTag->getType()] = $tag;
                return $tag;
            }
        }

        if ($tokenTag->getType() === null) {
            $textTag = new TextTag();
            $this->tokenCacheMap[$tokenTag->getType()] = $textTag;
        } else {
            // convert null to ''
            if ($tokenTag->getArgument() !== null) {
                $textTag = new UnknownSimpleType($tokenTag->getArgument());
            } else {
                $textTag = new UnknownSimpleType();
            }
            
            $this->tokenCacheMap[$tokenTag->getType()] = $textTag;
        }
        return $textTag;
    }
}
