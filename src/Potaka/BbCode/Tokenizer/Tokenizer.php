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
            $this->rootTag->addTag($tag);
        }

        return $this->rootTag;
    }
}
