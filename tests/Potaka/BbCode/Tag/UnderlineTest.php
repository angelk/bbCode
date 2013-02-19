<?php

/**
 * Description of BoldTest
 *
 * @author po_taka <angel.koilov@gmail.com
 */
class UnerlineTest extends PHPUnit_Framework_TestCase{
    public function testToHtml() {
        $tag = new Potaka\BbCode\Tag\Underline();
        $bbCode = '[u]u[/u]';
        $html = $tag->format($bbCode);
        $this->assertEquals($html, '<u>u</u>');
        
    }
}
