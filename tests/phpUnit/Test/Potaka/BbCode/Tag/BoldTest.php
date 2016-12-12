<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;
use Potaka\BbCode\Tag\Bold;

class BoldTest extends TestCase
{
    public function testToHtml()
    {
        $tag = new Bold();
        $tokenTag = new TokenTag('b');
        $tokenTag->setText('bold');
        $html = $tag->format($tokenTag);
        $this->assertEquals($html, '<b>bold</b>');
    }
}
