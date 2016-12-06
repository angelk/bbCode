<?php

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
class BbCodeTest extends PHPUnit_Framework_TestCase
{
    public function testAddingTag()
    {
        $bbCode = new Potaka\BbCode\BbCode();
        $tagBb = new Potaka\BbCode\Tag\Bold();

        $bbCode->addTag($tagBb);

        $this->assertEquals(array($tagBb), $bbCode->getTags());
    }
}
