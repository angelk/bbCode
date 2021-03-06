<?php

namespace Potaka\BbCode;

use Potaka\BbCode\Tag\TagInterface;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;
use Potaka\BbCode\TagBag\TagBag;

use Potaka\BbCode\Tag\TextTag;
use Potaka\BbCode\Tag\UnknownSimpleType;

/**
 * Format tokens to html
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

    private $allowedChildrenTags = [];

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

    public function addAllowedChildTag(TagInterface $root, TagInterface $child) : self
    {
        if (false === array_key_exists($root->getName(), $this->allowedChildrenTags)) {
            $this->allowedChildrenTags[$root->getName()] = [];
        }

        if (false === array_search($child, $this->allowedChildrenTags[$root->getName()])) {
            $this->allowedChildrenTags[$root->getName()][] = $child;
        }

        return $this;
    }

    public function getAllowedChildrenTags(TagInterface $tag) : array
    {
        if (false === array_key_exists($tag->getName(), $this->allowedChildrenTags)) {
            return [];
        }

        return $this->allowedChildrenTags[$tag->getName()];
    }

    public function format(TokenTag $tokenRootTag, TagBag $allowedTags = null) : string
    {
        $currentBbCodeType = $this->getBbCodeTagFromTokenTag($tokenRootTag);
        $currentElementAllowedTags = $this->getAllowedChildrenTags($currentBbCodeType);

        if ($allowedTags === null) {
            // get allowedTags from currentBBType
            $allowedTagsForChildren = new TagBag($currentElementAllowedTags);
            $tagAllowed = true;
        } else {
            $tagAllowed = $allowedTags->contains($currentBbCodeType);
            $allowedTagsForChildren = $allowedTags->intersect($currentElementAllowedTags);
        }

        $text = '';
        foreach ($tokenRootTag->getTags() as $tokenTag) {
            $text .= $this->format($tokenTag, $allowedTagsForChildren);
        }

        $tmpTag = clone $tokenRootTag;
        $tmpTag->setText($text . $tokenRootTag->getText());

        if ($tagAllowed) {
            $textFormatted = $currentBbCodeType->format($tmpTag);
        } else {
            $textFormatted = $currentBbCodeType->getOriginalText($tmpTag);
        }

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
