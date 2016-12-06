<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tag\Bold;

class BoldTest extends TestCase
{
    public function testToHtml()
    {
        $tag = new Bold();
        $bbCode = '[b]bold[/b]';
        $html = $tag->format($bbCode);
        $this->assertEquals($html, '<b>bold</b>');
    }
}
