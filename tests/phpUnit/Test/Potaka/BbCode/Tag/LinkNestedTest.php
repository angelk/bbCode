<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Factory;

/**
 * Description of LinkNestedTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class LinkNestedTest extends TestCase
{
    public function test1()
    {
        $bbcode = (new Factory())->getFullBbCode();
        $result = $bbcode->format('[url="http://google.bg]asd[b]www[/b][/url]');
        $this->assertSame('<a href="http://google.bg">asd<b>ww</b></a>', $result);
    }
}
