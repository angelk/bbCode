<?php

use PHPUnit\Framework\TestCase;

/**
 * @author po_taka <angel.koilov@gmail.com
 */
class UnerlineTest extends TestCase
{
    public function testToHtml()
    {
        $tag = new Potaka\BbCode\Tag\Underline();
        $bbCode = 'u';
        $html = $tag->format($bbCode);
        $this->assertEquals($html, '<u>u</u>');
    }
}
