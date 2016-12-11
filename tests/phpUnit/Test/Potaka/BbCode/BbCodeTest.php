<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\BbCode;
use Potaka\BbCode\Tag\Bold;

use Potaka\BbCode\Factory;

use Potaka\BbCode\Tokenizer\Tokenizer;

/**
 * @author po_taka <angel.koilov@gmail.com>
 */
class BbCodeTest extends TestCase
{
    private function assertBbCodeParsing($bbCodeString, $html)
    {
        $factory = new Factory();
        $bbCode = $factory->getFullBbCode();
        $tokenizer = new Tokenizer();
        $tokenized = $tokenizer->tokenize($bbCodeString);
        $result = $bbCode->format($tokenized);
        $this->assertSame($html, $result);

    }

    public function testAddingTag()
    {
        $bbCode = new BbCode();
        $tagBb = new Bold();
        $bbCode->addTag($tagBb);

        $this->assertEquals([$tagBb], $bbCode->getTags());
    }

    public function testSimpleTagParsing()
    {
        $this->assertBbCodeParsing('[b]B[/b]', '<b>B</b>');
    }
}
