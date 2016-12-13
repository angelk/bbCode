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
        $this->rootTag = new Tag(null);
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
                // [tag=argumen]
                $argumentFound = false;
                $argumentValue = '';
                $tmpPosion = $curentElement;
                $tagText = '';
                $tmpPosion++;
                while ($tmpPosion < $textLenght) {
                    if ($text[$tmpPosion] === ']') {
                        $closeTagFound = true;
                        break;
                    } elseif ($text[$tmpPosion] === '=') {
                        $argumentFound = true;
                    } else {
                        if ($argumentFound) {
                            $argumentValue .= $text[$tmpPosion];
                        } else {
                            $tagText .= $text[$tmpPosion];
                        }
                    }
                    $tmpPosion++;
                }

                if (false === $closeTagFound) {
                    $bufferText .= $currentChar . $tagText;
                    $curentElement = $tmpPosion;
                    continue;
                }

                $curentElement = $tmpPosion;
                
                if ($tagText[0] === '/') {
                    $tagName = mb_strcut($tagText, 1);
                    if ($currentTag->getType() === $tagName) {
                        if ($bufferText !== '') {
                            $tmpTag = new Tag(null);
                            $tmpTag->setText($bufferText);
                            $currentTag->addTag($tmpTag);
                        }
                        $currentTag = $currentTag->getParent();
                    } else {
                        // ? add to bufferText if fail ?
                        throw new \Exception("NI");
                    }
                } else {
                    $tmpTag = new Tag(null);
                    $tmpTag->setText($bufferText);
                    $currentTag->addTag($tmpTag);

                    $tmpTag = new Tag($tagText);

                    if ($argumentFound) {
                        $tmpTag->setArgumen($argumentValue);
                    }

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
            $tag = new Tag(null);
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
            $tagCode = "[{$tag->getType()}";
            if ($tag->getArgument()) {
                $tagCode .= "={$tag->getArgument()}";
            }
            $tagCode .= "]";

            $parent->removeTag($tag);

            // if parent last tag is text -> append text
            $parentTags = $parent->getTags();
            end($parentTags);
            $lastParentTag = current($parentTags);
            if ($lastParentTag->getType() === null) {
                $lastParentTag->setText("{$lastParentTag->getText()}{$tagCode}");
            } else {
                $curretntTagAsTextTag = new Tag(null);
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

        if ($lastTag->getType() !== null) {
            return true;
        }

        prev($tags);
        $postLastTag = current($tags);

        if ($postLastTag->getType() !== null) {
            return true;
        }

        $postLastTag->setText("{$postLastTag->getText()}{$lastTag->getText()}");
        $tag->removeTag($lastTag);
        return true;
    }
}
