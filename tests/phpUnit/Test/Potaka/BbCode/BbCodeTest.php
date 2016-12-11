<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\BbCode;
use Potaka\BbCode\Tag\Bold;

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
class BbCodeTest extends PHPUnit_Framework_TestCase
{
    public function testAddingTag()
    {
        $bbCode = new BbCode();
        $tagBb = new Bold();
        $bbCode->addTag($tagBb);

        $this->assertEquals(array($tagBb), $bbCode->getTags());
    }
}
