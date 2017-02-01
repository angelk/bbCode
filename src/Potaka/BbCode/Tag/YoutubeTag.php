<?php

namespace Potaka\BbCode\Tag;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;
use Tekstove\UrlVideoParser\Youtube\YoutubeParser;
use Tekstove\UrlVideoParser\Youtube\YoutubeException;

/**
 * Tag for youtube videos
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class YoutubeTag implements TagInterface
{
    public function format(TokenTag $tokenTag): string
    {
        $link = $tokenTag->getText();

        try {
            $parser = new YoutubeParser();
            $videoId = $parser->getId($link);
        } catch (YoutubeException $e) {
            $unknownTag = new UnknownSimpleType();
            return $unknownTag->format($tokenTag);
        }

        return '<iframe src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allowfullscreen></iframe>';
    }

    public function getName(): string
    {
        return 'youtube';
    }

    public function getOriginalText(TokenTag $tokenTag): string
    {
        return "[{$this->getName()}]{$tokenTag->getText()}[/{$this->getName()}";
    }
}
