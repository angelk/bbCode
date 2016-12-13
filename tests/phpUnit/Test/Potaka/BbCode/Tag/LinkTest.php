<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tokenizer\Tag as TokenTag;

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
        $tokenTag = new TokenTag('url');
        $tokenTag->setText('searchEngine');
        $tokenTag->setArgumen('http://google.bg');

        $link = new Link();
        $html = $link->format($tokenTag);
        $this->assertSame('<a href="http://google.bg" target="_blank">searchEngine</a>', $html);
    }

    public function testDoNotAllowLinkInLink()
    {
        $this->markTestSkipped("@TODO");
        $link = new Link();
        $html = $link->format('[url=http://google.bg]go[url=http://google.bg]og[/url]le[/url]');
        $this->assertSame('[url=http://google.bg]go<a href="http://google.bg">og</a>le[/url]', $html);
    }
}
