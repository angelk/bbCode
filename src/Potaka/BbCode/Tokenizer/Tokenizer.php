<?php

namespace Potaka\BbCode\Tokenizer;

/**
 * Description of Tokenizer
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class Tokenizer
{
    private $tokens = [];

    public function tokenize($text)
    {
        $curentElement = 0;
        $textLenght = mb_strlen($text);
        $bufferText = '';
        $openTags = [];
        $openBraceCount = 0;
        while ($curentElement < $textLenght) {
            $currentChar = $text[$curentElement];
            if ($currentChar === '[') {
                if ($openBraceCount === 0) {
                    $this->tokens[] = [
                        'type' => 'text',
                        'text' => $bufferText,
                    ];
                    $bufferText = '';
                    $openBraceCount++;
                }
            } elseif ($currentChar === ']') {
                if ($bufferText[0] === '/') {
                    $closeTag = $bufferText;
                    $element = mb_strcut($bufferText, 1);
                    // search for corresponding open tag
                    $tagFound = false;
                    for ($i = count($openTags) - 1; $i >= 0; $i--) {
                        if ($openTags[$i]['type'] === $element) {
                            $tagFound = true;
                            unset($openTags[$i]);

                            $this->tokens[] = [
                                [
                                    'tag' => $element,
                                ]
                            ];

                            break;
                        }
                    }
                } else {
                    $openTag = $bufferText;
                    $element = $bufferText;
                    $openTags[] = [
                        'type' => $openTag,
                    ];
                }
                $bufferText = '';
            } else {
                $bufferText .= $currentChar;
            }

            $curentElement++;
        }

        return $this->tokens;
    }
}
