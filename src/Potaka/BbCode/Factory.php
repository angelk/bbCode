<?php

namespace Potaka\BbCode;

use Potaka\BbCode\Tag\Bold;
use Potaka\BbCode\Tag\Underline;
use Potaka\BbCode\Tag\Italic;

use Potaka\BbCode\Tag\Link;

/**
 * Create different BbCode configurations
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Factory
{
    /**
     * Create fully configured BbCode
     *
     * @return BbCode
     */
    public function getFullBbCode() : BbCode
    {
        $bbcode = new BbCode();

        $bold = new Bold();
        $bbcode->addTag($bold);

        $underline = new Underline();
        $bbcode->addTag($underline);

        $italic = new Italic();
        $bbcode->addTag($italic);

        $link = new Link;
        $bbcode->addTag($link);

        $unknownTag = new Tag\UnknownSimpleType();
        $bbcode->addTag($unknownTag);

        $tags = [
            $bold,
            $underline,
            $italic,
            $link,
            $unknownTag,
        ];

        // link allowed
        $bbcode->addAllowedChildTag($link, $bold);
        $bbcode->addAllowedChildTag($link, $italic);
        $bbcode->addAllowedChildTag($link, $underline);
        $bbcode->addAllowedChildTag($link, $unknownTag);

        $tagsAllowingAnyChild = [
            $bold,
            $italic,
            $underline,
            $unknownTag,
        ];

        foreach ($tagsAllowingAnyChild as $tagAllowingAnyTag) {
            foreach ($tags as $tag) {
                $bbcode->addAllowedChildTag($tagAllowingAnyTag, $tag);
            }
        }

        return $bbcode;
    }
}
