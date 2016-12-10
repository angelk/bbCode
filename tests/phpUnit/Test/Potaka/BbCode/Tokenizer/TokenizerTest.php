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
    private function assertSameTokenized($expected, $result)
    {
        $resultStrng = print_r($result, true);
        $expectedString = print_r($expected, true);

        $this->assertSame($expectedString, $resultStrng);
    }

    public function testSimpleTokenize()
    {
        $tokenizer = new Tokenizer();
        $text = 'w[b]z[/b]';
        $tokenized = $tokenizer->tokenize($text);
        
        $expected = new Tag('text');
        $expected->addTag(
            (new Tag('text'))
                ->setText('w')
        );
        $expected->addTag(
            (new Tag('b'))
                ->addTag(
                    (new Tag('text'))->setText('z')
                )
        );

        $this->assertSameTokenized($expected, $tokenized);
    }

    public function testNestedTokenize()
    {
        $tokenizer = new Potaka\BbCode\Tokenizer\Tokenizer();
        $text = 'w[b]B[u]U[/u][/b]';
        $tokenized = $tokenizer->tokenize($text);

        $expected = new Tag('text');
        $expected->addTag(
            (new Tag('text'))->setText('w')
        );

        $expected->addTag(
            (new Tag('b'))->addTag(
                (new Tag('text'))->setText('B')
            )->addTag(
                (new Tag('u'))->addTag(
                    (new Tag('text'))->setText('U')
                )
            )
        );

        $this->assertSameTokenized($expected, $tokenized);
    }
}
