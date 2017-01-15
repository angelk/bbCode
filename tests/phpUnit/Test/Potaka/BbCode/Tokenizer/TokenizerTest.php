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
        
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))
                ->setText('w')
        );
        $expected->addTag(
            (new Tag('b'))
                ->addTag(
                    (new Tag(null))->setText('z')
                )
        );

        $this->assertSameTokenized($expected, $tokenized);
    }

    public function testNestedTokenize()
    {
        $tokenizer = new Tokenizer();
        $text = 'w[b]B[u]U[/u][/b]';
        $tokenized = $tokenizer->tokenize($text);

        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('w')
        );

        $expected->addTag(
            (new Tag('b'))->addTag(
                (new Tag(null))->setText('B')
            )->addTag(
                (new Tag('u'))->addTag(
                    (new Tag(null))->setText('U')
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
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('asdf')
        );
        $this->assertSameTokenized($expected, $result);
    }


    public function testEmptyTag()
    {
        $tokenizer = new Tokenizer();
        $text = '[]';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('[]')
        );
        $this->assertSameTokenized($expected, $result);
    }

    public function testNotClosedTag()
    {
        $tokenizer = new Tokenizer();
        $text = 'as[d]f';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('as[d]f')
        );
        $this->assertSameTokenized($expected, $result);
    }

    public function testNotClosedNestedTag()
    {
        $tokenizer = new Tokenizer();
        $text = 'as[d]f[u]r';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('as[d]f[u]r')
        );
        $this->assertSameTokenized($expected, $result);
    }

    public function testWrongOrderOfClosingTags()
    {
        $tokenizer = new Tokenizer();
        $text = '[b]B[u]U[/b][/u]';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('[b]')
        )->addTag(
            (new Tag(null))->setText('B')
        )->addTag(
            (new Tag('u'))->addTag(
                (new Tag(null))->setText('U[/b]')
            )
        );

        $this->assertSameTokenized($expected, $result);
    }

    public function testUnclosedTagContainingClosedTag()
    {
        $tokenizer = new Tokenizer();
        $text = 'as[d]f[u]r[b]B[/b]';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('as[d]f[u]r')
        )->addTag(
            (new Tag('b'))->addTag(
                (new Tag(null))->setText('B')
            )
        );

        $expectedFallback = new Tag(null);
        $expectedFallback->addTag(
            (new Tag(null))->setText('as[d]')
        )->addTag(
            (new Tag(null))->setText('f[u]')
        )->addTag(
            (new Tag(null))->setText('r')
        )->addTag(
            (new Tag('b'))->addTag(
                (new Tag(null))->setText('B')
            )
        );

        try {
            $this->assertSameTokenized($expected, $result);
        } catch (\Exception $e) {
            $this->assertSameTokenized($expectedFallback, $result);
        }
    }

    public function testSimpleTokenizationWithArgument()
    {
        $tokenizer = new Tokenizer();
        $text = 'a[url=http://google.bg]google[/url]';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('a')
        )->addTag(
            (new Tag('url'))->setArgumen('http://google.bg')->addTag(
                (new Tag(null))->setText('google')
            )
        );

        $this->assertSameTokenized($expected, $result);
    }

    public function testNotClosedTagWithArgument()
    {
        $tokenizer = new Tokenizer();
        $text = 'a[url=http://google.bg]google';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('a[url=http://google.bg]google')
        );

        $this->assertSameTokenized($expected, $result);
    }

    public function testTokenizerReuse()
    {
        $tokenizer = new Tokenizer();
        $text = 'a';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('a')
        );

        $this->assertSameTokenized($expected, $result);

        $textReuse = 'b';
        $resultReuse = $tokenizer->tokenize($textReuse);
        $expectedReuse = new Tag(null);
        $expectedReuse->addTag(
            (new Tag(null))->setText('b')
        );

        $this->assertSameTokenized($expectedReuse, $resultReuse);
    }

    public function testCyrillicChars()
    {
        $tokenizer = new Tokenizer();
        $text = 'удебелен текст';
        $result = $tokenizer->tokenize($text);
        $expected = new Tag(null);
        $expected->addTag(
            (new Tag(null))->setText('удебелен текст')
        );

        $this->assertSameTokenized($expected, $result);
    }
}
