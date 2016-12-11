<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\BbCode;
use Potaka\BbCode\Tag\Bold;

class BoldTest extends TestCase
{
    public function testToHtml()
    {
        $tag = new Bold();
        $text = 'bold';
        $html = $tag->format($text);
        $this->assertEquals($html, '<b>bold</b>');
    }
}
