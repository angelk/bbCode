<?php

use PHPUnit\Framework\TestCase;

use Potaka\BbCode\Tokenizer\Tag;
use Potaka\BbCode\Tokenizer\Tokenizer;

/**
 * Description of TokenizerTest
 *
 * @author po_taka <angel.koilov@gmail.com>
 */
class TokenizerTest extends TestCase
{
    public function testSimpleTokenize()
    {
        $tokenizer = new Tokenizer();
        $text = 'w[b]z[/b]';
        $tokenized = $tokenizer->tokenize($text);
        $expected = new Tag('text');

        $tmpTag = new Tag('text');
        $tmpTag->setText('w');

        $expected->addTag($tmpTag);

        $tmpTag = new Tag('b');
        $tmpTagText = new Tag('text');
        $tmpTagText->setText('z');
        $tmpTag->addTag($tmpTagText);
        $expected->addTag($tmpTag);

        $resultS = serialize($tokenized);
        $expectedS = serialize($expected);

        $this->assertSame($expectedS, $resultS);
    }
}
