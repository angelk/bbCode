<?php

/**
 * Description of BoldTest
 *
 * @author po_taka <angel.koilov@gmail.com
 */
class ItalicTest extends PHPUnit_Framework_TestCase {

    public function testToHtml() {
        $tag = new Potaka\BbCode\Tag\Italic();
        $bbCode = '[i]i[/i]';
        $html = $tag->format($bbCode);
        $this->assertEquals($html, '<i>i</i>');
    }

}
