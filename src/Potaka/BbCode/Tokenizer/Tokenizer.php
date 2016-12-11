<?php

namespace Potaka\BbCode\Tokenizer;

/**
 * Description of Tokenizer
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Tokenizer
{
    private $rootTag;

    public function __construct()
    {
        $this->rootTag = new Tag('text');
    }


    public function tokenize($text)
    {
        $curentElement = 0;
        $textLenght = mb_strlen($text);
        $bufferText = '';
        $currentTag = $this->rootTag;
        while ($curentElement < $textLenght) {
            $currentChar = $text[$curentElement];
            if ($currentChar === '[' && ($curentElement+1 < $textLenght) && $text[$curentElement+1] !== ']') {
                // get the close bracket
                $closeTagFound = false;
                $tmpPosion = $curentElement;
                $tagText = '';
                $tmpPosion++;
                while ($tmpPosion < $textLenght) {
                    if ($text[$tmpPosion] === ']') {
                        $closeTagFound = true;
                        break;
                    } else {
                        $tagText .= $text[$tmpPosion];
                    }
                    $tmpPosion++;
                }

                if (false === $closeTagFound) {
                    $bufferText .= $currentChar;
                    $currentChar++;
                    continue;
                }

                $curentElement = $tmpPosion;
                
                if ($tagText[0] === '/') {
                    $tagName = mb_strcut($tagText, 1);
                    if ($currentTag->getType() === $tagName) {
                        if ($bufferText !== '') {
                            $tmpTag = new Tag('text');
                            $tmpTag->setText($bufferText);
                            $currentTag->addTag($tmpTag);
                        }
                        $currentTag = $currentTag->getParent();
                    } else {
                        // ? add to bufferText if fail ?
                        throw new \Exception("NI");
                    }
                } else {
                    $tmpTag = new Tag('text');
                    $tmpTag->setText($bufferText);
                    $currentTag->addTag($tmpTag);

                    $tmpTag = new Tag($tagText);
                    $currentTag->addTag($tmpTag);
                    $currentTag = $tmpTag;
                }
                
                $bufferText = '';
            } else {
                $bufferText .= $currentChar;
            }

            $curentElement++;
        }

        if ($bufferText) {
            $tag = new Tag('text');
            $tag->setText($bufferText);
            $currentTag->addTag($tag);
        }

        $this->handleNotClosedTags($currentTag);
        return $this->rootTag;
    }

    private function handleNotClosedTags(Tag $tag)
    {
        while ($tag->getParent() !== null) {
            $parent = $tag->getParent();
            $tagCode = "[{$tag->getType()}]";

            $parent->removeTag($tag);

            // if parent last tag is text -> append text
            $parentTags = $parent->getTags();
            end($parentTags);
            $lastParentTag = current($parentTags);
            if ($lastParentTag->getType() === 'text') {
                $lastParentTag->setText("{$lastParentTag->getText()}{$tagCode}");
            } else {
                $curretntTagAsTextTag = new Tag('text');
                $curretntTagAsTextTag->setText($tagCode);
                $parent->addTag($curretntTagAsTextTag);
            }
            
            foreach ($tag->getTags() as $tagToMove) {
                $parent->addTag($tagToMove);
            }

            $tag = $tag->getParent();
            if ($tag !== null) {
                $this->mergeLastTextTags($tag);
            }
        }
    }

    /**
     * @param Tag $tag
     * @return boolean
     */
    private function mergeLastTextTags(Tag $tag)
    {
        $tags = $tag->getTags();
        if (count($tags) < 2) {
            return true;
        }

        end($tags);
        $lastTag = current($tags);

        if ($lastTag->getType() !== 'text') {
            return true;
        }

        prev($tags);
        $postLastTag = current($tags);

        if ($postLastTag->getType() !== 'text') {
            return true;
        }

        $postLastTag->setText("{$postLastTag->getText()}{$lastTag->getText()}");
        $tag->removeTag($lastTag);
        return true;
    }
}
