<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tag\Link;

/**
 * Description of LinkTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class LinkTest extends TestCase
{
    public function testParse()
    {
        $link = new Link();
        $html = $link->format('[url=http://google.bg]google[/url]');
        $this->assertSame('<a href="http://google.bg">google</a>', $html);
    }

    public function testDoNotAllowLinkInLink()
    {
        $link = new Link();
        $html = $link->format('[url=http://google.bg]go[url=http://google.bg]og[/url]le[/url]');
        $this->assertSame('[url=http://google.bg]go<a href="http://google.bg">og</a>le[/url]', $html);
    }
}
