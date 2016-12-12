<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 * @author po_taka <angel.koilov@gmail.com
 */
class ItalicTest extends PHPUnit_Framework_TestCase
{
    public function testToHtml()
    {
        $tag = new Potaka\BbCode\Tag\Italic();
        $tokenTag = new TokenTag('i');
        $tokenTag->setText('i');
        $html = $tag->format($tokenTag);
        $this->assertEquals($html, '<i>i</i>');
    }
}
