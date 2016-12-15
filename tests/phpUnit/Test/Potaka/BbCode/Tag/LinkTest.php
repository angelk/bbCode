<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Factory;
use Potaka\BbCode\Tokenizer\Tokenizer;
use Potaka\BbCode\Tokenizer\Tag as TokenTag;

use Potaka\BbCode\Tag\Link;

/**
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
        $factory = new Factory();
        $fullBbCode = $factory->getFullBbCode();
        $tokenizer = new Tokenizer();
        $tokenized = $tokenizer->tokenize('[url=http://google.bg]1[url=http://google.bg]2[/url]3[/url]');

        $result = $fullBbCode->format($tokenized);
        $this->assertSame(
            '<a href="http://google.bg" target="_blank">1[url=http://google.bg]2[/url]3</a>',
            $result
        );
    }
    public function testLinkWithBoldInisdeTest()
    {
        $bbcode = (new Factory())->getFullBbCode();
        $tokenizer = new Tokenizer();
        $tokenized = $tokenizer->tokenize('[url=http://google.bg]asd[b]w[/b][/url]');
        $result = $bbcode->format($tokenized);
        $this->assertSame('<a href="http://google.bg" target="_blank">asd<b>w</b></a>', $result);
    }
}
