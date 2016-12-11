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
        $tokenizer = new Tokenizer();
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

    public function testNoTokenizing()
    {
        $tokenizer = new Tokenizer();
        $text = 'asdf';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag('text');
        $expected->addTag(
            (new Tag('text'))->setText('asdf')
        );
        $this->assertSameTokenized($expected, $result);
    }


    public function testEmptyTag()
    {
        $tokenizer = new Tokenizer();
        $text = '[]';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag('text');
        $expected->addTag(
            (new Tag('text'))->setText('[]')
        );
        $this->assertSameTokenized($expected, $result);
    }

    public function testNotClosedTag()
    {
        $tokenizer = new Tokenizer();
        $text = 'as[d]f';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag('text');
        $expected->addTag(
            (new Tag('text'))->setText('as[d]f')
        );
        $this->assertSameTokenized($expected, $result);
    }

    public function testNotClosedNestedTag()
    {
        $tokenizer = new Tokenizer();
        $text = 'as[d]f[u]r';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag('text');
        $expected->addTag(
            (new Tag('text'))->setText('as[d]f[u]r')
        );
        $this->assertSameTokenized($expected, $result);
    }

    public function testUnclosedTagContainingClosedTag()
    {
        $tokenizer = new Tokenizer();
        $text = 'as[d]f[u]r[b]B[/b]';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag('text');
        $expected->addTag(
            (new Tag('text'))->setText('as[d]f[u]r')
        )->addTag(
            (new Tag('b'))->addTag(
                (new Tag('text'))->setText('B')
            )
        );

        $expectedFallback = new Tag('text');
        $expectedFallback->addTag(
            (new Tag('text'))->setText('as[d]')
        )->addTag(
            (new Tag('text'))->setText('f[u]')
        )->addTag(
            (new Tag('text'))->setText('r')
        )->addTag(
            (new Tag('b'))->addTag(
                (new Tag('text'))->setText('B')
            )
        );

        try {
            $this->assertSameTokenized($expected, $result);
        } catch (\Exception $e) {
            $this->assertSameTokenized($expectedFallback, $result);
        }
    }
}
