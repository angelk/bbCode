<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

/**
 * @author po_taka <angel.koilov@gmail.com
 */
class UnerlineTest extends TestCase
{
    public function testToHtml()
    {
        $tag = new Potaka\BbCode\Tag\Underline();
        $tokenTag = new TokenTag('u');
        $tokenTag->setText('u');
        $html = $tag->format($tokenTag);
        $this->assertEquals($html, '<u>u</u>');
    }
}
