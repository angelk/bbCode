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
            if ($currentChar === '[') {
                // get the close bracket
                $closeTagFound = false;
                $tmpPosion = $curentElement;
                $tagText = '';
                do {
                    $tmpPosion++;
                    if ($text[$tmpPosion] === ']') {
                        $closeTagFound = true;
                        break;
                    } else {
                        $tagText .= $text[$tmpPosion];
                    }
                } while ($tmpPosion < $textLenght);

                if (false === $closeTagFound) {
                    $bufferText .= $currentChar;
                    $currentChar++;
                    continue;
                }

                $curentElement = $tmpPosion;
                
                if ($tagText[0] === '/') {
                    $tagName = mb_strcut($tagText, 1);
                    if ($currentTag->getType() === $tagName) {
                        $tmpTag = new Tag('text');
                        $tmpTag->setText($bufferText);
                        $currentTag->addTag($tmpTag);
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

        return $this->rootTag;
    }
}

class Tag
{
    private $tags = [];
    private $type;
    private $parent = null;
    private $text;

    public function __construct($type)
    {
        $this->type = $type;
    }

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
