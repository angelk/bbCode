<?php

namespace Potaka\BbCode\Tokenizer;

/**
 * Transform text into tokens for bbcode
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Tokenizer
{
    private $rootTag;

    public function tokenize($text)
    {
        $this->rootTag = new Tag(null);
        $curentElement = 0;
        $textAsArray = preg_split('//u', $text);
        $textLenght = count($textAsArray);
        
        $bufferText = '';
        $currentTag = $this->rootTag;
        while ($curentElement < $textLenght) {
            $currentChar = $textAsArray[$curentElement];
            if ($currentChar === '[' && ($curentElement+1 < $textLenght) && $textAsArray[$curentElement+1] !== ']') {
                // get the close bracket
                $closeTagFound = false;
                // [tag=argumen]
                $argumentFound = false;
                $argumentValue = '';
                $tmpPosion = $curentElement;
                $tagText = '';
                $tmpPosion++;
                while ($tmpPosion < $textLenght) {
                    if ($textAsArray[$tmpPosion] === ']') {
                        $closeTagFound = true;
                        break;
                    // for the time being we support only 1 argument
                    } elseif ($textAsArray[$tmpPosion] === '=' && $argumentFound === false) {
                        $argumentFound = true;
                    } else {
                        if ($argumentFound) {
                            $argumentValue .= $textAsArray[$tmpPosion];
                        } else {
                            $tagText .= $textAsArray[$tmpPosion];
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
                        $bufferText .= "[{$tagText}]";
                        $curentElement = $tmpPosion + 1;
                        continue;
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
