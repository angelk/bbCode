<?php

/**
 * Description of BoldTest
 *
 * @author po_taka <angel.koilov@gmail.com
 */
class BoldTest extends PHPUnit_Framework_TestCase{
    public function testToHtml() {
        $tag = new Potaka\BbCode\Tag\Bold();
        $bbCode = '[b]bold[/b]';
        $html = $tag->format($bbCode);
        $this->assertEquals($html, '<b>bold</b>');
        
    }
}
